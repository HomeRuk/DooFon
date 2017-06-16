<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ModelRequest extends Request {

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
            'data' => 'required|file|mimetypes:text/plain|max:30720',
            //'selModel' => 'required|string',
            //'debug' => 'required',
            'maxDepth' => 'required|integer|min:0',
            'numFeatures' => 'required|integer|min:0',
            'numTrees' => 'required|integer|min:0',
            'seed' => 'required|integer|min:0',
        ];
    }

    public function messages() {
        return [
            //'SerialNumber.required' => 'กรุณากรอกรหัสอุปกรณ์',
        ];
    }

}
