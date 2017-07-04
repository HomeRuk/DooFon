<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Device_UsersRequest extends Request {
    
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
            'SerialNumber' => 'required|size:10',
        ];
    }

    public function messages() {
        return [
            'SerialNumber.required' => 'กรุณากรอกรหัสอุปกรณ์',
            'SerialNumber.size' => 'กรุณากรอกรหัสอุปกรณ์10ตัวอักษร',
            'SerialNumber.unique' => 'กรุณากรอกรหัสอุปกรณ์นี้มีอยู่แล้ว',
        ];
    }

}
