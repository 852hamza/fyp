<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Testimonial;
use Carbon\Carbon;
use Toastr;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|file',  // Changed validation to 'file'
            'testimonial' => 'required|max:200'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->name);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('testimonial')) {
                Storage::disk('public')->makeDirectory('testimonial');
            }
            $testimonialImage = Image::make($image)->resize(160, 160)->stream();
            Storage::disk('public')->put('testimonial/'.$imagename, $testimonialImage);
        } else {
            $imagename = 'default.png';  // Handle cases where file is not an image
        }

        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->testimonial = $request->testimonial;
        $testimonial->image = $imagename;
        $testimonial->save();

        Toastr::success('Testimonial created successfully.');
        return redirect()->route('admin.testimonials.index');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'file',  // Changed validation to 'file'
            'testimonial' => 'required|max:200',
        ]);

        $testimonial = Testimonial::find($id);
        $image = $request->file('image'); 
        $slug  = str_slug($request->name);  // Corrected slug source to 'name'

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('testimonial')) {
                Storage::disk('public')->makeDirectory('testimonial');
            }
            if (Storage::disk('public')->exists('testimonial/'.$testimonial->image)) {
                Storage::disk('public')->delete('testimonial/'.$testimonial->image);
            }
            $testimonialImage = Image::make($image)->resize(160, 160)->stream();
            Storage::disk('public')->put('testimonial/'.$imagename, $testimonialImage);
        } else if (!isset($image)) {
            $imagename = $testimonial->image;  // Maintain old image if not updated
        }

        $testimonial->name = $request->name;
        $testimonial->testimonial = $request->testimonial;
        $testimonial->image = $imagename;
        $testimonial->save();

        Toastr::success('Testimonial updated successfully.');
        return redirect()->route('admin.testimonials.index');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        if (Storage::disk('public')->exists('testimonial/'.$testimonial->image)) {
            Storage::disk('public')->delete('testimonial/'.$testimonial->image);
        }

        $testimonial->delete();

        Toastr::success('Testimonial deleted successfully.');
        return back();
    }
}
