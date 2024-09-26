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

        // Calculate 2% fee and add it to the original price
        $price = $request->input('price');
        $priceWithFee = $price + ($price * 0.02); // Add 2% to the price

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
        // $property->price = $request->price;
        $property->price = $priceWithFee;
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

    // public function update(Request $request, Property $property)
    // {
    //     $request->validate([
    //         'title' => 'required|max:255',
    //         'price' => 'required|numeric',
    //         'purpose' => 'required',
    //         'type' => 'required',
    //         'bedroom' => 'required|integer',
    //         'bathroom' => 'required|integer',
    //         'city' => 'required',
    //         'address' => 'required',
    //         'area' => 'required|numeric',
    //         'image' => 'nullable|image',
    //         'floor_plan' => 'nullable|image',
    //         'description' => 'required',
    //         'location_latitude' => 'required|numeric',
    //         'location_longitude' => 'required|numeric',
    //     ]);

    //     // Calculate 2% fee and add it to the original price
    //     $price = $request->input('price');
    //     $priceWithFee = $price + ($price * 0.02); // Add 2% to the price

    //      // Update the existing property
    //     $property->title = $request->title;
    //     $property->slug = \Illuminate\Support\Str::slug($request->title); // Update slug in case title has changed
    //     $property->price = $priceWithFee; // Update the price with the 2% added
    //     $property->purpose = $request->purpose;
    //     $property->type = $request->type;
    //     $property->bedroom = $request->bedroom;
    //     $property->bathroom = $request->bathroom;
    //     $property->city = $request->city;
    //     $property->address = $request->address;
    //     $property->area = $request->area;
    //     $property->description = $request->description;
    //     $property->location_latitude = $request->location_latitude;
    //     $property->location_longitude = $request->location_longitude;

    //     $property->fill($request->except(['image', 'floor_plan', 'galleryimage']));

    //     $slug = \Illuminate\Support\Str::slug($request->title); // Use Laravel's helper for slugging
    //     $property->slug = $slug; // Update slug in case title has changed

    //     if ($request->hasFile('image')) {
    //         $property->image = $this->uploadImage($request->file('image'), 'property', $slug);
    //     }

    //     if ($request->hasFile('floor_plan')) {
    //         $property->floor_plan = $this->uploadImage($request->file('floor_plan'), 'property', 'floor-plan-' . $slug);
    //     }

    //     $property->featured = $request->has('featured'); // Simplify feature toggle
    //     $property->save();

    //     $property->features()->sync($request->input('features', []));
    //     // $this->uploadGalleryImages($request, $property);

    //     Toastr::success('Property updated successfully.', 'Success');
    //     return redirect()->route('admin.properties.index');
    // }
    public function update(Request $request, Property $property)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'purpose' => 'required',
            'type' => 'required',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'city' => 'required',
            'address' => 'required',
            'area' => 'required|numeric',
            'image' => 'nullable|image',
            'floor_plan' => 'nullable|image',
            'description' => 'required',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
        ]);

        // Ensure the price is being received correctly
        $price = $request->input('price');

        // Check if price is not null or empty
        if (is_null($price) || empty($price)) {
            \Log::error('Price is missing in the request.');
            return redirect()->back()->withErrors('Price is required.');
        }

        // Calculate 2% fee and add it to the original price
        $priceWithFee = $price + ($price * 0.02);

        // Log the calculated price for debugging
        \Log::info("Calculated price with 2% fee: $priceWithFee");

        // Update the existing property
        $property->title = $request->input('title');
        $property->slug = \Illuminate\Support\Str::slug($request->input('title'));
        $property->price = $priceWithFee;  // Set the price with the 2% added
        $property->purpose = $request->input('purpose');
        $property->type = $request->input('type');
        $property->bedroom = $request->input('bedroom');
        $property->bathroom = $request->input('bathroom');
        $property->city = $request->input('city');
        $property->address = $request->input('address');
        $property->area = $request->input('area');
        $property->description = $request->input('description');
        $property->location_latitude = $request->input('location_latitude');
        $property->location_longitude = $request->input('location_longitude');

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $property->image = $this->uploadImage($request->file('image'), 'property', $property->slug);
        }

        // Handle Floor Plan Upload
        if ($request->hasFile('floor_plan')) {
            $property->floor_plan = $this->uploadImage($request->file('floor_plan'), 'property', 'floor-plan-' . $property->slug);
        }

        // Set the featured flag
        $property->featured = $request->has('featured');

        // Log all property fields before saving to check if they are correct
        \Log::info('Property fields before save:', $property->toArray());

        // Save the updated property
        $property->save();

        // Sync features
        $property->features()->sync($request->input('features', []));

        // Display success message
        Toastr::success('Property updated successfully with 2% fee added to the price.', 'Success');

        // Redirect back to the properties index
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
