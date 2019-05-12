<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class FacebookloginController extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $userSocial = Socialite::driver('facebook')->user();
        //return $userSocial;
        $finduser = User::where('facebook_id', $userSocial->id)->first();
        if($finduser){
            Auth::login($finduser);
            return Redirect::to('/');
        }else{
            $new_user = User::create([
            'name'      => $userSocial->name,
            'email'      => $userSocial->email,
            'facebook_id'=> $userSocial->id
        ]);
        Auth::login($new_user);
        return redirect()->back();
        }
    }
}

