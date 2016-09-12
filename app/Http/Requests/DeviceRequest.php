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
            'temp' => 'required',
            'humidity' => 'required',
            'dewpoint' => 'required',
            'pressure' => 'required',
            'light' => 'required',
            'rain' => 'required',
        ];
    }

    public function forbiddenResponse() {
        return response()->view('errors.503');
    }

}
