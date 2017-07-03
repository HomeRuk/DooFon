<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequest;
use App\Device;
use App\Weather;
use Jcf\Geocode\Geocode;
use Alert;

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
        $devices = Device::where('SerialNumber', 'like', '%' . $searchSerialNumber . '%')
            ->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.device.index', [
            'devices' => $devices,
        ]);// admin/device/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       /* return view('admin.device.create');
        // Device/create.blade.php*/
    }

    /**
     * Store Device
     * URL Path : /Devices
     * Method : POST
     * @param DeviceRequest $request
     * @internal param $App /Http/Requests/DeviceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeviceRequest $request)
    {
        try {
            Device::create($request->all()); //$fillable
        } catch (\Exception $e) {
            Alert::error('บันทึกรายการอุปกรณ์IoT ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\DeviceController@index');
        }
        Alert::success('บันทึกรายการอุปกรณ์IoT สำเร็จ!', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\DeviceController@index');
    }

    public function edit($id)
    {
      /*  $device = Device::findOrFail($id);
        if (empty($device)) {
            abort(404);
        }
        return view('admin.device.edit', [
            'device' => $device,
        ]);*/
    }

    public function update(Request $request, $id)
    {
        try {
            Device::findOrFail($id)->update(
                [
                    'threshold' => $request->threshold,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]
            );
        } catch (\Exception $e) {
            Alert::error('ปรับปรุงรายการอุปกรณ์IoT ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\DeviceController@show',['id' => $id]);
        }
        Alert::success('ปรับปรุงรายการอุปกรณ์IoT สำเร็จ !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\DeviceController@show',['id' => $id]);
    }

    public function show($id)
    {
        $device = Device::findOrFail($id);
        $dWeather = Weather::where('devices_id', '=', $device->id)->orderBy('id', 'asc')->paginate(50);
        try {
            $response = Geocode::make()->latLng($device->latitude, $device->longitude);
            $response ? $address = $response->formattedAddress(): $address = null;
        } catch (\Exception $e) {
            $response = null;
            $address = null;
        }
        return view('admin.device.show', [
            'device' => $device,
            'dWeathers' => $dWeather,
            'address' => $address
        ]); // admin/device/show.blade.php
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Remove row SerialNumber foreign key
        try {
            Device::findOrFail($id)->delete();
        } catch (\Exception $e) {
            Alert::error('ลบรายการอุปกรณ์IoT ผิดพลาด !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
            return redirect()->action('Admin\DeviceController@index');
        }
        Alert::success('ลบรายการอุปกรณ์IoT สำเร็จ !', 'ผลการทำงาน')->persistent('ปิด')->autoclose(3500);
        return redirect()->action('Admin\DeviceController@index');
    }
}
