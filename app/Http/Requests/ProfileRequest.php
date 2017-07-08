<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileRequest extends Request {
    
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
            'name' => 'required|String',
            'email' => 'required|email',
            'tel' => 'required|String',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'email.required' => 'กรุณากรอกอีเมล์',
            'email.email' => 'กรุณากรอกอีเมล์ให้ถูกต้อง',
            'tel.required' => 'กรุณากรอกตัวเลขเบอร์โทรศัพท์',
        ];
    }

}
