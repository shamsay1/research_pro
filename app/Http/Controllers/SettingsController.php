<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SETTINGS PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Check logged in user
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('student')->check()) {

            $user = Auth::guard('student')->user();

            $guard = 'student';

        } elseif (Auth::guard('web')->check()) {

            $user = Auth::guard('web')->user();

            $guard = 'web';

        } else {

            return redirect()->route('login');

        }


        /*
        |--------------------------------------------------------------------------
        | Return settings page
        |--------------------------------------------------------------------------
        */

        return view(
            'setting',
            compact(
                'user',
                'guard'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Determine logged in user
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('student')->check()) {

            $user = Auth::guard('student')->user();

            $guard = 'student';

        } elseif (Auth::guard('web')->check()) {

            $user = Auth::guard('web')->user();

            $guard = 'web';

        } else {

            return redirect()->route('login');

        }


        /*
        |--------------------------------------------------------------------------
        | Validate password
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'current_password' => [
                'required',
                'string'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],

        ], [

            'current_password.required' =>
                'Please enter your current password.',

            'password.required' =>
                'Please enter your new password.',

            'password.min' =>
                'New password must be at least 8 characters.',

            'password.confirmed' =>
                'New password confirmation does not match.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Check current password
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'current_password' =>
                        'Your current password is incorrect.'
                ])
                ->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent same password
        |--------------------------------------------------------------------------
        */

        if (
            Hash::check(
                $request->password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'password' =>
                        'Your new password must be different from your current password.'
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Update password
        |--------------------------------------------------------------------------
        */

        $user->password = Hash::make(
            $request->password
        );

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Keep user logged in
        |--------------------------------------------------------------------------
        */

        Auth::guard($guard)->login($user);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Your password has been changed successfully.'
        );
    }
}