<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Property;
use App\Feature;
use App\PropertyImageGallery;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Toastr;
use Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->withCount('comments')->get();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $features = Feature::all();
        return view('admin.properties.create', compact('features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:properties|max:255',
            'price' => 'required',
            'purpose' => 'required',
            'type' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'city' => 'required',
            'address' => 'required',
            'area' => 'required',
            'image' => 'required|file',
            'floor_plan' => 'file',
            'description' => 'required',
            'location_latitude' => 'required',
            'location_longitude' => 'required',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            $propertyimage = Image::make($image)->stream();
            Storage::disk('public')->put('property/' . $imagename, $propertyimage);
        } else {
            $imagename = 'default.png';
        }

        $floor_plan = $request->file('floor_plan');
        if (isset($floor_plan) && strpos($floor_plan->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagefloorplan = 'floor-plan-' . $currentDate . '-' . uniqid() . '.' . $floor_plan->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            $propertyfloorplan = Image::make($floor_plan)->stream();
            Storage::disk('public')->put('property/' . $imagefloorplan, $propertyfloorplan);
        } else {
            $imagefloorplan = 'default.png';
        }

        $property = new Property();
        $property->title = $request->title;
        $property->slug = $slug;
        $property->price = $request->price;
        $property->purpose = $request->purpose;
        $property->type = $request->type;
        $property->image = $imagename;
        $property->bedroom = $request->bedroom;
        $property->bathroom = $request->bathroom;
        $property->city = $request->city;
        $property->city_slug = str_slug($request->city);
        $property->address = $request->address;
        $property->area = $request->area;
        $property->description = $request->description;
        $property->location_latitude = $request->location_latitude;
        $property->location_longitude = $request->location_longitude;
        $property->floor_plan = $imagefloorplan;
        if (isset($request->featured)) {
            $property->featured = true;
        }
        $property->agent_id = Auth::id();
        $property->save();
        $property->features()->attach($request->features);

        $gallery = $request->file('galleryimage');
        if ($gallery) {
            foreach ($gallery as $images) {
                if (isset($images) && strpos($images->getMimeType(), 'image') === 0) {
                    $currentDate = Carbon::now()->toDateString();
                    $galImage = 'gallery-' . $currentDate . '-' . uniqid() . '.' . $images->getClientOriginalExtension();

                    if (!Storage::disk('public')->exists('property/gallery')) {
                        Storage::disk('public')->makeDirectory('property/gallery');
                    }
                    $galleryImage = Image::make($images)->stream();
                    Storage::disk('public')->put('property/gallery/' . $galImage, $galleryImage);

                    $property->gallery()->create(['name' => $galImage, 'size' => $images->getClientSize(), 'property_id' => $property->id]);
                }
            }
        }

        Toastr::success('Property created successfully.', 'Success');
        return redirect()->route('admin.properties.index');
    }

    public function show(Property $property)
    {
        $property = Property::withCount('comments')->find($property->id);
        $videoembed = $this->convertYoutube($property->video, 560, 315);
        return view('admin.properties.show', compact('property', 'videoembed'));
    }

    public function edit(Property $property)
    {
        $features = Feature::all();
        $property = Property::find($property->id);
        $videoembed = $this->convertYoutube($property->video);
        return view('admin.properties.edit', compact('property', 'features', 'videoembed'));
    }

    public function update(Request $request, $property)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'required',
            'purpose' => 'required',
            'type' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'city' => 'required',
            'address' => 'required',
            'area' => 'required',
            'image' => 'file',
            'floor_plan' => 'file',
            'description' => 'required',
            'location_latitude' => 'required',
            'location_longitude' => 'required'
        ]);

        $property = Property::find($property);  // Correctly fetch the property instance

        if (!$property) {
            Toastr::error('Property not found.', 'Error');
            return redirect()->route('admin.properties.index');
        }

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            if (Storage::disk('public')->exists('property/' . $property->image)) {
                Storage::disk('public')->delete('property/' . $property->image);
            }
            $propertyimage = Image::make($image)->stream();
            Storage::disk('public')->put('property/' . $imagename, $propertyimage);
            $property->image = $imagename; // Update the image attribute
        }

        $floor_plan = $request->file('floor_plan');
        if (isset($floor_plan) && strpos($floor_plan->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagefloorplan = 'floor-plan-' . $currentDate . '-' . uniqid() . '.' . $floor_plan->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            if (Storage::disk('public')->exists('property/' . $property->floor_plan)) {
                Storage::disk('public')->delete('property/' . $property->floor_plan);
            }
            $propertyfloorplan = Image::make($floor_plan)->stream();
            Storage::disk('public')->put('property/' . $imagefloorplan, $propertyfloorplan);
            $property->floor_plan = $imagefloorplan; // Update the floor plan attribute
        }

        // Update other property fields
        $property->title = $request->title;
        $property->price = $request->price;
        $property->purpose = $request->purpose;
        $property->type = $request->type;
        $property->bedroom = $request->bedroom;
        $property->bathroom = $request->bathroom;
        $property->city = $request->city;
        $property->city_slug = str_slug($request->city);
        $property->address = $request->address;
        $property->area = $request->area;
        $property->description = $request->description;
        $property->location_latitude = $request->location_latitude;
        $property->location_longitude = $request->location_longitude;

        if (isset($request->featured)) {
            $property->featured = true;
        } else {
            $property->featured = false;
        }

        $property->save();
        $property->features()->sync($request->features);

        Toastr::success('Property updated successfully.', 'Success');
        return redirect()->route('admin.properties.index');
    }

    public function destroy(Property $property)
    {
        if (Storage::disk('public')->exists('property/' . $property->image)) {
            Storage::disk('public')->delete('property/' . $property->image);
        }
        if (Storage::disk('public')->exists('property/' . $property->floor_plan)) {
            Storage::disk('public')->delete('property/' . $property->floor_plan);
        }

        $property->delete();

        $galleries = $property->gallery;
        foreach ($galleries as $gallery) {
            if (Storage::disk('public')->exists('property/gallery/' . $gallery->name)) {
                Storage::disk('public')->delete('property/gallery/' . $gallery->name);
            }
            $gallery->delete();
        }

        $property->features()->detach();
        $property->comments()->delete();

        Toastr::success('Property deleted successfully.', 'Success');
        return back();
    }

    public function galleryImageDelete(Request $request)
    {
        $galleryimg = PropertyImageGallery::find($request->id);
        if (Storage::disk('public')->exists('property/gallery/' . $galleryimg->name)) {
            Storage::disk('public')->delete('property/gallery/' . $galleryimg->name);
        }
        $galleryimg->delete();

        if ($request->ajax()) {
            return response()->json(['msg' => true]);
        }
    }

    // YOUTUBE LINK TO EMBED CODE
    private function convertYoutube($youtubeLink, $width = 560, $height = 315)
    {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe width=\"$width\" height=\"$height\" src=\"//www.youtube.com/embed/$2\" frameborder=\"0\" allowfullscreen></iframe>",
            $youtubeLink
        );
    }
}
