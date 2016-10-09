<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DeviceRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'SerialNumber' => 'required|size:10',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'threshold' => 'required|integer',
        ];
    }

    public function messages() {
        return [
            //'SerialNumber.required' => 'กรุณากรอกรหัสอุปกรณ์',
        ];
    }
    
    public function forbiddenResponse() {
        return response()->view('errors.503');
    }

}
