<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\User;
use App\Profiles;

class ProfilesController extends Controller
{
    /**
     * Device Weather
     * URL Path : user/profile
     * Method : GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = User::with('profiles')->find(Auth::user()->id);
        return view('user.profile.index', [
            'user' => $user,
        ]);// user/profile/index.blade.php
    }

    public function update(ProfileRequest $request)
    {
        $id = Auth::user()->id;
        try {
            User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $profiles = Profiles::where('usersp_id','=',$id)->first();
            if (isset($profiles)) {
                $profiles->tel = $request->tel;
                $profiles->save();
            } else {
                $profiles = new Profiles();
                $profiles->tel = $request->tel;
                $profiles->usersp_id = Auth::user()->id;
                $profiles->save();
            }
        } catch (\Exception $e) {
            return back();
        }
        return back();
    }
}
