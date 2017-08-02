<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use Alert;
use Image;
use File;

class Account_ManagementController extends Controller
{
    public function index(Request $request)
    {
        $searchUsername = $request->get('name');
        $user = User::where('name', 'like', '%' . $searchUsername . '%')
            ->orderBy('updated_at', 'desc')->paginate(10);
        $userIdNew = User::orderBy('updated_at', 'desc')->first()->id;
        return view('admin.account_management.index', [
            'users' => $user,
            'userIdNew' => $userIdNew
        ]);
    }

    /**
     * Store Device
     * URL Path : /Admin/Devices
     * Method : POST
     * @param UserRequest $request
     * @internal param $App /Http/Requests/DeviceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => $request->status,
            ]);
            //$fillable
        } catch (\Exception $e) {
            Alert::error('บันทึกรายการบัญชีผู้ใช้ ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\Account_ManagementController@index');
        }
        Alert::success('บันทึกรายการบัญชีผู้ใช้ สำเร็จ!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\Account_ManagementController@index');
    }

    public function show($id)
    {
        $user = User::with('profile')->findOrFail($id);
        /* dd($user->profile);*/
        return view('admin.account_management.show', [
            'user' => $user,
        ]);
    }

    public function update(ProfileRequest $request, $id)
    {
        try {
            User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $profile = Profile::where('usersp_id', '=', $id)->first();

            // Check record profile
            if (!isset($profile)) {
                $profile = new Profile();
                $profile->usersp_id = $id;
                $profile->image = 'nopic.pic';
            }
            $profile->tel = $request->tel;

            //upload image
            if ($request->hasFile('image')) {
                //delete file
                if ($profile->image != 'nopic.pic') {
                    File::delete(public_path() . '/images/' . $profile->image);
                    File::delete(public_path() . '/images_resize/50/' . $profile->image);
                    File::delete(public_path() . '/images_resize/128/' . $profile->image);
                    File::delete(public_path() . '/images_resize/256/' . $profile->image);
                }

                $newfilename = str_random(10) . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path() . '/images/', $newfilename);
                //resize image
                Image::make(public_path() . '/images/' . $newfilename)->resize(50, 50)->save(public_path() . '/images_resize/50/' . $newfilename);
                Image::make(public_path() . '/images/' . $newfilename)->resize(128, 128)->save(public_path() . '/images_resize/128/' . $newfilename);
                Image::make(public_path() . '/images/' . $newfilename)->resize(256, 256)->save(public_path() . '/images_resize/256/' . $newfilename);
                $profile->image = $newfilename;
            } else {
                $profile->image = $profile->image; //ชื่อเดิม
            }
           /* dd($request->hasFile('image'));*/
            $profile->save();

        } catch (\Exception $e) {
            dd($e);
            Alert::error('ปรับปรุงข้อมูลบัญชีผู้ใช้ ผิดพลาด! <br/> กรุณาตรวจสอบข้อมูล!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return back();
        }
        Alert::success('ปรับปรุงข้อมูลบัญชีผู้ใช้ สำเร็จ!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return back();
    }

    public function destroy($id)
    {
        //Remove row user foreign key
        try {
            User::findOrFail($id)->delete();
        } catch (\Exception $e) {
            Alert::error('ลบบัญชีผู้ใช้ ผิดพลาด! <br/> กรุณาตรวจสอบข้อมูล!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\Account_ManagementController@index');
        }
        Alert::success('ลบบัญชีผู้ใช้ สำเร็จ!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\Account_ManagementController@index');
    }
}
