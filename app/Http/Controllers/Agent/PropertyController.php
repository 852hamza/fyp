<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Property;
use App\Feature;
use App\PropertyImageGallery;
use Carbon\Carbon;
use Toastr;
use Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()
                              ->withCount('comments')
                              ->where('agent_id', Auth::id())
                              ->paginate(10);
        
        return view('agent.properties.index', compact('properties'));
    }

    public function create()
    {   
        $features = Feature::all();
        return view('agent.properties.create', compact('features'));
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
            'image' => 'required|file',  // Accept any file type
            'floor_plan' => 'file',  // Accept any file type
            'description' => 'required',
            'location_latitude' => 'nullable',
            'location_longitude' => 'nullable',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            $propertyImage = Image::make($image)->resize(1600, 1066)->stream();
            Storage::disk('public')->put('property/'.$imageName, $propertyImage);
        } else {
            $imageName = 'default.png';  // Fallback for non-image files
        }

        $floorPlan = $request->file('floor_plan');
        if (isset($floorPlan) && strpos($floorPlan->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imageFloorPlan = 'floor-plan-' . $currentDate . '-' . uniqid() . '.' . $floorPlan->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            $floorPlanImage = Image::make($floorPlan)->resize(800, 600)->stream();
            Storage::disk('public')->put('property/'.$imageFloorPlan, $floorPlanImage);
        } else {
            $imageFloorPlan = 'default.png';  // Fallback for non-image floor plans
        }

        $property = new Property();
        $property->title = $request->title;
        $property->slug = $slug;
        $property->price = $request->price;
        $property->purpose = $request->purpose;
        $property->type = $request->type;
        $property->image = $imageName;
        $property->bedroom = $request->bedroom;
        $property->bathroom = $request->bathroom;
        $property->city = $request->city;
        $property->city_slug = str_slug($request->city);
        $property->address = $request->address;
        $property->area = $request->area;
        $property->agent_id = Auth::id();
        $property->video = $request->video;
        $property->floor_plan = $imageFloorPlan;
        $property->description = $request->description;
        $property->location_latitude = $request->location_latitude;
        $property->location_longitude = $request->location_longitude;
        if (isset($request->featured)) {
            $property->featured = true;
        }
        $property->save();

        $property->features()->attach($request->features);

        $gallery = $request->file('galleryimage');
        if ($gallery) {
            foreach ($gallery as $images) {
                if (isset($images) && strpos($images->getMimeType(), 'image') === 0) {
                    $currentDate = Carbon::now()->toDateString();
                    $galleryImageName = 'gallery-' . $currentDate . '-' . uniqid() . '.' . $images->getClientOriginalExtension();

                    if (!Storage::disk('public')->exists('property/gallery')) {
                        Storage::disk('public')->makeDirectory('property/gallery');
                    }
                    $galleryImage = Image::make($images)->resize(500, 500)->stream();
                    Storage::disk('public')->put('property/gallery/' . $galleryImageName, $galleryImage);

                    $property->gallery()->create([
                        'name' => $galleryImageName,
                        'size' => $images->getClientSize(),
                        'property_id' => $property->id
                    ]);
                }
            }
        }

        Toastr::success('Property created successfully.');
        return redirect()->route('agent.properties.index');
    }

    public function edit(Property $property)
    {   
        $features = Feature::all();
        $property = Property::where('slug', $property->slug)->first();
        return view('agent.properties.edit', compact('property', 'features'));
    }

    public function update(Request $request, Property $property)
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
            'image' => 'file',  // Allow any file type
            'floor_plan' => 'file',  // Allow any file type
            'description' => 'required',
            'location_latitude' => 'nullable',
            'location_longitude' => 'nullable'
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            if (Storage::disk('public')->exists('property/' . $property->image)) {
                Storage::disk('public')->delete('property/' . $property->image);
            }
            $propertyImage = Image::make($image)->resize(1600, 1066)->stream();
            Storage::disk('public')->put('property/' . $imageName, $propertyImage);
        } else {
            $imageName = $property->image; // Use existing image if no new image is uploaded
        }

        $floorPlan = $request->file('floor_plan');
        if (isset($floorPlan) && strpos($floorPlan->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imageFloorPlan = 'floor-plan-' . $currentDate . '-' . uniqid() . '.' . $floorPlan->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('property')) {
                Storage::disk('public')->makeDirectory('property');
            }
            if (Storage::disk('public')->exists('property/' . $property->floor_plan)) {
                Storage::disk('public')->delete('property/' . $property->floor_plan);
            }
            $floorPlanImage = Image::make($floorPlan)->resize(800, 600)->stream();
            Storage::disk('public')->put('property/' . $imageFloorPlan, $floorPlanImage);
        } else {
            $imageFloorPlan = $property->floor_plan; // Use existing floor plan if no new one is uploaded
        }

        $property->title = $request->title;
        $property->slug = $slug;
        $property->price = $request->price;
        $property->purpose = $request->purpose;
        $property->type = $request->type;
        $property->image = $imageName;
        $property->bedroom = $request->bedroom;
        $property->bathroom = $request->bathroom;
        $property->city = $request->city;
        $property->city_slug = str_slug($request->city);
        $property->address = $request->address;
        $property->area = $request->area;
        $property->description = $request->description;
        $property->location_latitude = $request->location_latitude;
        $property->location_longitude = $request->location_longitude;
        $property->floor_plan = $imageFloorPlan;
        $property->save();

        $property->features()->sync($request->features);

        Toastr::success('Property updated successfully.');
        return redirect()->route('agent.properties.index');
    }

    public function destroy(Property $property)
    {
        if (Storage::disk('public')->exists('property/' . $property->image)) {
            Storage::disk('public')->delete('property/' . $property->image);
        }

        $property->delete();
        $property->features()->detach();
        $property->gallery()->each(function ($gallery) {
            if (Storage::disk('public')->exists('property/gallery/' . $gallery->name)) {
                Storage::disk('public')->delete('property/gallery/' . $gallery->name);
            }
            $gallery->delete();
        });

        Toastr::success('Property deleted successfully.');
        return back();
    }

    public function galleryImageDelete(Request $request)
    {
        $galleryImg = PropertyImageGallery::find($request->id);
        if (galleryImg && Storage::disk('public')->exists('property/gallery/' . $galleryImg->name)) {
            Storage::disk('public')->delete('property/gallery/' . $galleryImg->name);
        }

        if ($galleryImg) {
            $galleryImg->delete();
        }

        if ($request->ajax()) {
            return response()->json(['msg' => true]);
        }
    }
}
