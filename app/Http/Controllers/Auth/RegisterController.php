<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name'      => 'required|string|max:255',
    //         'email'     => 'required|string|email|max:255|unique:users',
    //         'password'  => 'required|string|min:6|confirmed',
    //     ]);
    // }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            // 'phone' => [
            //     'required',
            //     'regex:/^\+92[0-9]{9}$/',  // Validates phone numbers starting with +92 and exactly 9 digits
            //     'unique:users', // Make sure phone numbers are unique
            //     'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            // ],
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $username   = strtok($data['username'], " ");
        $roleid     = isset($data['agent']) ? 2 : 3;

        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'username'  => $username,
            'role_id'   => $roleid
        ]);
    }
    public function checkUsername(Request $request)
    {
        $exists = User::where('username', $request->username)->exists();
        return response()->json(!$exists); // returns true if username is not taken, false otherwise
    }
    public function checkEmail(Request $request)
{
    $exists = User::where('email', $request->email)->exists();
    return response()->json(!$exists); // returns false if email is taken, true otherwise
}

}
