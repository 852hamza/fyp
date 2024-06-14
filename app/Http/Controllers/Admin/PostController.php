<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Tag;
use App\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Toastr;
use Auth;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->withCount('comments')->get();

        return view('admin.posts.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|unique:posts|max:255',
            'image'     => 'required|file', // Accepts any file type
            'categories' => 'required',
            'tags'      => 'required',
            'body'      => 'required'
        ]);

        $file = $request->file('image');
        $slug  = str_slug($request->title);

        if (isset($file)) {
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }
            Storage::disk('public')->put('posts/' . $filename, file_get_contents($file));
        } else {
            $filename = 'default.png';
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $filename;
        $post->body = $request->body;
        $post->status = $request->has('status');
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        Toastr::success('Post created successfully.');
        return redirect()->route('admin.posts.index');
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'image'     => 'file', // Accepts any file type
            'categories' => 'required',
            'tags'      => 'required',
            'body'      => 'required'
        ]);

        $file = $request->file('image');
        $slug  = str_slug($request->title);

        if (isset($file)) {
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }
            if (Storage::disk('public')->exists('posts/' . $post->image)) {
                Storage::disk('public')->delete('posts/' . $post->image);
            }
            Storage::disk('public')->put('posts/' . $filename, file_get_contents($file));
        } else {
            $filename = $post->image; // Use existing file if no new file is uploaded
        }

        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $filename;
        $post->body = $request->body;
        $post->status = $request->has('status');
        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post updated successfully.');
        return redirect()->route('admin.posts.index');
    }



    public function show(Post $post)
    {
        $post = Post::withCount('comments')->find($post->id);

        return view('admin.posts.show', compact('post'));
    }


    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::find($post->id);

        $selectedtag = $post->tags->pluck('id');

        return view('admin.posts.edit', compact('categories', 'tags', 'post', 'selectedtag'));
    }




    public function destroy(Post $post)
    {
        $post = Post::find($post->id);

        if (Storage::disk('public')->exists('posts/' . $post->image)) {
            Storage::disk('public')->delete('posts/' . $post->image);
        }

        $post->delete();
        $post->categories()->detach();
        $post->tags()->detach();
        $post->comments()->delete();

        Toastr::success('message', 'Post deleted successfully.');
        return back();
    }
}
