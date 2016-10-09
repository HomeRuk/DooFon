<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DeviceRequest;
use App\Device;

class DeviceController extends Controller
{
        public function __construct() {
        $this->middleware('auth',['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$count = Device::count();
        $device = Device::paginate(50);
        return view('device.index',[
	    'count' => $count,
            'devices' => $device,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('device.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insert()
    {
        return view('device.insert');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceRequest $request)
    {
        $Device = new Device();
        //$Device->name = $request->name;
        //$Device->save();
        $Device->create($request->all()); //$fillable
        $request->session()->flash('status', 'บันทึกเรียบร้อยแล้ว');
        //return back();
        return redirect()->action('DeviceController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function show($SerialNumber)
    {
        $Dserialnumber = Device::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('device.show',[
            'Dserialnumbers' => $Dserialnumber
        ]); // Device/show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy($SerialNumber)
    {
        $device = Device::where('SerialNumber', $SerialNumber)->delete();
        return back();
    }
}
