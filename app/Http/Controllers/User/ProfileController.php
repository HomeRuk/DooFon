<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\User;
use App\Profile;
use Alert;

class ProfileController extends Controller
{
    /**
     * Device Weather
     * URL Path : user/profile
     * Method : GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = User::with('profile')->find(Auth::user()->id);
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
            $profiles = Profile::where('usersp_id','=',$id)->first();
            if (isset($profiles)) {
                $profiles->tel = $request->tel;
                $profiles->save();
            } else {
                $profiles = new Profile();
                $profiles->tel = $request->tel;
                $profiles->usersp_id = Auth::user()->id;
                $profiles->save();
            }
        } catch (\Exception $e) {
            Alert::error('ปรับปรุงข้อมูลส่วนตัว ผิดพลาด! <br/> กรุณาตรวจสอบข้อมูล!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return back();
        }
        Alert::success('ปรับปรุงข้อมูลส่วนตัว สำเร็จ!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return back();
    }
}
