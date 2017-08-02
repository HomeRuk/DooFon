<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request {
    
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
            'name' => 'required|min:6|max:100',
            'username' => 'required|min:6|max:100|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:16|confirmed',
            'status' => 'required|in:User,Admin',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'กรุณากรอกชื่อที่แสดง',
            'name.min' => 'กรุณากรอกชื่อที่แสดงอย่างน้อย 6 ตัวอักษร',
            'name.max' => 'กรุณากรอกชื่อที่แสดงไม่เกิน 100 ตัวอักษร',
            'username.required' => 'กรุณากรอกชื่อบัญชี',
            'username.min' => 'กรุณากรอกชื่อบัญชีอย่างน้อย 6 ตัวอักษร',
            'username.max' => 'กรุณากรอกชื่อบัญชีไม่เกิน 100 ตัวอักษร',
            'username.unique' => 'กรุณาเปลี่ยนชื่อบัญชีเนื่องจากชื่อบัญชีนี้มีอยู่แล้ว',
            'email.required' => 'กรุณากรอกอีเมล์',
            'email.email' => 'กรุณากรอกอีเมล์ให้ถูกต้อง',
            'email.unique' => 'กรุณาเปลี่ยนอีเมล์เนื่องจากอีเมล์นี้มีอยู่แล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร',
            'password.max' => 'กรุณากรอกรหัสผ่านไม่เกิน 16 ตัวอักษร',
            'password.confirmed' => 'กรุณากรอกยืนยันรหัสผ่าน',
            'status.required' => 'กรุณาเลือกสถานะ',
        ];
    }

}
