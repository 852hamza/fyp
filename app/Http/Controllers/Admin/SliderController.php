<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Slider;
use Carbon\Carbon;
use Toastr;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:sliders|max:255',
            'image' => 'required|file'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->title);

        if(isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('slider')){
                Storage::disk('public')->makeDirectory('slider');
            }

            if (strpos($image->getMimeType(), 'image') === 0) {
                $img = Image::make($image)->resize(1600, 480)->stream();
                Storage::disk('public')->put('slider/'.$imagename, $img);
            } else {
                $image->storeAs('slider', $imagename, 'public');
            }
        } else {
            $imagename = 'default.png';
        }

        $slider = new Slider();
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->image = $imagename;
        $slider->save();

        Toastr::success('Slider created successfully.', 'Success');
        return redirect()->route('admin.sliders.index');
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'file'
        ]);

        $slider = Slider::find($id);
        $image = $request->file('image');
        $slug = str_slug($request->title);

        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('slider')) {
                Storage::disk('public')->makeDirectory('slider');
            }
            if (Storage::disk('public')->exists('slider/'.$slider->image)) {
                Storage::disk('public')->delete('slider/'.$slider->image);
            }

            if (strpos($image->getMimeType(), 'image') === 0) {
                $img = Image::make($image)->resize(1600, 480)->stream();
                Storage::disk('public')->put('slider/'.$imagename, $img);
            } else {
                $image->storeAs('slider', $imagename, 'public');
            }
        } else {
            $imagename = $slider->image; // Keeps the old image if no new image is uploaded
        }

        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->image = $imagename;
        $slider->save();

        Toastr::success('Slider updated successfully.', 'Success');
        return redirect()->route('admin.sliders.index');
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);

        if (Storage::disk('public')->exists('slider/'.$slider->image)) {
            Storage::disk('public')->delete('slider/'.$slider->image);
        }

        $slider->delete();
        Toastr::success('Slider deleted successfully.', 'Success');
        return back();
    }
}
