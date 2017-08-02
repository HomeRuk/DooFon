<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserFCMTokenwebRequest extends Request {

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
            'user_id' => 'required',
            'FCMTokenweb' => 'required|string|max:200',
            'sid' => 'required|string',
        ];
    }

    public function messages() {
        return [

        ];
    }
    
    public function forbiddenResponse() {
        return response()->view('errors.503');
    }

}
