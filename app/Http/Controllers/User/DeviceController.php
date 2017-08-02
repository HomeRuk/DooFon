<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Device_UsersRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequest;
use App\Device;
use App\Weather;
use App\User;
use DB;
use Jcf\Geocode\Geocode;
use Illuminate\Support\Facades\Auth;
use Alert;
use QrCode;
use File;

class DeviceController extends Controller
{
    /**
     * Device Weather
     * URL Path : /Weathers
     * Method : GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $searchSerialNumber = $request->get('search');
        $devices = User::findOrFail(Auth::user()->id)->device()
            ->where('SerialNumber', 'like', '%' . $searchSerialNumber . '%')
            ->orderBy('updated_at', 'desc')->paginate(10);
        $deviceIdNew = Device::orderBy('updated_at', 'desc')->first()->id;
        return view('user.device.index', [
            'devices' => $devices,
            'deviceIdNew' => $deviceIdNew
        ]);// user/device/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store Device
     * URL Path : /Devices
     * Method : POST
     * @param DeviceRequest $request
     * @internal param $App /Http/Requests/DeviceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Device_UsersRequest $request)
    {
        $SerialNumber = $request->SerialNumber;
        try {
            $user = User::find(Auth::user()->id);
            $device = Device::where('SerialNumber', '=', $SerialNumber)->first();
            $user->device()->save($device);
        } catch (\Exception $e) {
            Alert::error('บันทึกรายการอุปกรณ์IoTผิดพลาด <br/> กรุณาตรวจสอบข้อมูล!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('User\DeviceController@index');
        }
        Alert::success('บันทึกรายการอุปกรณ์IoT สำเร็จ!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('User\DeviceController@index');
    }

    public function edit()
    {
        return abort(404);
    }

    public function update(Request $request, $device_id)
    {
        try {
            User::findOrFail(Auth::user()->id)->device()
                ->findOrFail($device_id)->update([
                    'threshold' => $request->threshold,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
        } catch (\Exception $e) {
            Alert::error('ปรับปรุงรายการอุปกรณ์IoT ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('User\DeviceController@show', ['id' => $device_id]);
        }
        Alert::success('ปรับปรุงรายการอุปกรณ์IoT สำเร็จ !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('User\DeviceController@show', ['id' => $device_id]);
    }

    public function show($device_id)
    {
        $device = User::find(Auth::user()->id)->device()->findOrFail($device_id);
        $dWeather = Weather::where('devices_id', '=', $device->id)->orderBy('id', 'asc')->paginate(50);
        $qrcodeFile = public_path() . '/qrcodes/' . $device->SerialNumber . '.png';
        if (!File::exists($qrcodeFile)) {
            QrCode::format('png')
                ->merge('../public/images/rain64.png', .15)
                ->size(300)
                ->margin(2)
                ->generate($device->SerialNumber, '../public/qrcodes/'.$device->SerialNumber.'.png');
        }
        try {
            $response = Geocode::make()->latLng($device->latitude, $device->longitude);
            $response ? $address = $response->formattedAddress() : $address = null;
        } catch (\Exception $e) {
            $response = null;
            $address = null;
        }
        return view('user.device.show', [
            'device' => $device,
            'dWeathers' => $dWeather,
            'address' => $address
        ]); // user/device/show.blade.php
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy($device_id)
    {
        //Remove row from device_id in device_users table
        try {
            $user = User::find(Auth::user()->id);
            $user->device()->detach($device_id);
        } catch (\Exception $e) {
            Alert::error('ลบรายการอุปกรณ์IoT ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('User\DeviceController@index');
        }
        Alert::success('ลบรายการอุปกรณ์IoT สำเร็จ !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('User\DeviceController@index');
    }
}

