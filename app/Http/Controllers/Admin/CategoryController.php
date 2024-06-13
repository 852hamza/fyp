<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Category;
use Carbon\Carbon;
use Toastr;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'image' => 'required|file',  // Changed to accept any file type
            // 'testimonial' => 'required|max:200'
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            if (!Storage::disk('public')->exists('category/thumb')) {
                Storage::disk('public')->makeDirectory('category/thumb');
            }

            $sliderImage = Image::make($image)->resize(1600, 480)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename, $sliderImage);

            $thumbImage = Image::make($image)->resize(500, 330)->stream();
            Storage::disk('public')->put('category/thumb/'.$imagename, $thumbImage);
        } else {
            $imagename = 'default.png';  // Fallback for non-image files
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();

        Toastr::success('Category created successfully.');
        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'file',  // Changed to accept any file type
        ]);

        $category = Category::find($id);
        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            if (Storage::disk('public')->exists('category/slider/' . $category->image)) {
                Storage::disk('public')->delete('category/slider/' . $category->image);
            }

            $sliderImage = Image::make($image)->resize(1600, 480)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename, $sliderImage);

            if (!Storage::disk('public')->exists('category/thumb')) {
                Storage::disk('public')->makeDirectory('category/thumb');
            }
            if (Storage::disk('public')->exists('category/thumb/' . $category->image)) {
                Storage::disk('public')->delete('category/thumb/' . $category->image);
            }

            $thumbImage = Image::make($image)->resize(500, 330)->stream();
            Storage::disk('public')->put('category/thumb/'.$imagename, $thumbImage);
        } else {
            $imagename = $category->image;  // If no new image is uploaded, use the existing one
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();

        Toastr::success('Category updated successfully.');
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (Storage::disk('public')->exists('category/slider/'.$category->image)) {
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }

        if (Storage::disk('public')->exists('category/thumb/'.$category->image)) {
            Storage::disk('public')->delete('category/thumb/'.$category->image);
        }

        $category->delete();
        Toastr::success('Category deleted successfully.');
        return back();
    }
}
