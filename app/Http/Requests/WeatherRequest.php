<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class WeatherRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true; //true ไม่ต้อง auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'temp' => 'required|numeric|min:-40|max:80',
            'humidity' => 'required|numeric|min:0|max:100',
            'dewpoint' => 'required|numeric|min:-40|max:80',
            'pressure' => 'required|numeric|min:300|max:1100',
            'light' => 'required|integer|min:0|max:1023',
            'rain' => 'required|in:0,1',
            'SerialNumber' => 'required|size:10',
        ];
    }

    public function forbiddenResponse() {
        return response()->view('errors.503');
    }

}
