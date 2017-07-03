<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DeviceRequest extends Request {

     /**
     * The URI to redirect to if validation fails.
     *
     * @var string
     */
    // redirect ถ้าไม่เป็นไปตาม rule 
    //protected $redirect = 'device';
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true; //true ไม่ต้อง login
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'SerialNumber' => 'required|size:10|unique:device',
            'threshold' => 'required|integer|min:0|max:100',
            //'users_id' => 'required|integer',
            //'latitude' => 'required|numeric',
            //'longitude' => 'required|numeric',
        ];
    }

    public function messages() {
        return [
            'SerialNumber.required' => 'กรุณากรอกรหัสอุปกรณ์',
            'SerialNumber.size' => 'กรุณากรอกรหัสอุปกรณ์10ตัวอักษร',
            'SerialNumber.unique' => 'กรุณากรอกรหัสอุปกรณ์นี้มีอยู่แล้ว',
            'threshold.required' => 'กรุณาตั้งค่าเปอร์เซนพยากรณ์ฝนคก',
            'threshold.integer' => 'กรุณาตั้งค่าเปอร์เซนพยากรณ์ฝนคกเป็นตัวเลข',
        ];
    }

}
