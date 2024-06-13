<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Mail\Contact;
use Carbon\Carbon;
use App\Property;
use App\Message;
use App\User;
use Auth;
use Hash;
use Toastr;

class DashboardController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->where('agent_id', Auth::id())->take(5)->get();
        $propertytotal = Property::where('agent_id', Auth::id())->count();
        $messages = Message::latest()->where('agent_id', Auth::id())->take(5)->get();
        $messagetotal = Message::where('agent_id', Auth::id())->count();

        return view('agent.dashboard', compact('properties', 'propertytotal', 'messages', 'messagetotal'));
    }

    public function profile()
    {
        $profile = Auth::user();
        return view('agent.profile', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'image' => 'file',  // Accept any file type
            'about' => 'max:250'
        ]);

        $user = User::find(Auth::id());
        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image) && strpos($image->getMimeType(), 'image') === 0) {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-agent-' . Auth::id() . '-' . $currentDate . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('users')) {
                Storage::disk('public')->makeDirectory('users');
            }
            if (Storage::disk('public')->exists('users/' . $user->image) && $user->image != 'default.png') {
                Storage::disk('public')->delete('users/' . $user->image);
            }
            $userImage = Image::make($image)->resize(300, 300)->stream();
            Storage::disk('public')->put('users/' . $imageName, $userImage);
            $user->image = $imageName;
        } else {
            $imageName = $user->image ?? 'default.png';  // Use existing image if no new image is uploaded
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->about = $request->about;
        $user->save();

        Toastr::success('Profile updated successfully.');
        return back();
    }

    public function changePassword()
    {
        return view('agent.changepassword');
    }

    public function changePasswordUpdate(Request $request)
    {
        if (!Hash::check($request->get('currentpassword'), Auth::user()->password)) {
            Toastr::error('Your current password does not match with the password you provided! Please try again.');
            return redirect()->back();
        }
        if (strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0) {
            Toastr::error('New Password cannot be same as your current password! Please choose a different password.');
            return redirect()->back();
        }

        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('newpassword'));
        $user->save();

        Toastr::success('Password changed successfully.');
        return redirect()->back();
    }

    // Message handling methods
    public function message()
    {
        $messages = Message::latest()->where('agent_id', Auth::id())->paginate(10);
        return view('agent.messages.index', compact('messages'));
    }

    public function messageRead($id)
    {
        $message = Message::findOrFail($id);
        return view('agent.messages.read', compact('message'));
    }

    public function messageReplay($id)
    {
        $message = Message::findOrFail($id);
        return view('agent.messages.replay', compact('message'));
    }

    public function messageSend(Request $request)
    {
        $request->validate([
            'agent_id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        Message::create($request->all());

        Toastr::success('Message sent successfully.');
        return back();
    }

    public function messageReadUnread(Request $request)
    {
        $message = Message::findOrFail($request->messageid);
        $message->status = $request->status ? 0 : 1;
        $message->save();

        return redirect()->route('agent.message');
    }

    public function messageDelete($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        Toastr::success('Message deleted successfully.');
        return back();
    }

    public function contactMail(Request $request)
    {
        Mail::to($request->email)->send(new Contact($request->message, $request->name, $request->mailfrom));

        Toastr::success('Mail sent successfully.');
        return back();
    }
}
