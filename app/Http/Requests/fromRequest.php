<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class fromRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                    //字段的规则设定
                    'wechat'=>'required',
                    'phone'=>'required|digits:11',
                    'name'=>'required|max:11',
                    'message'=>'required|min:1|max:200',
                ];
    }

    public function messages() {
    $messages = [
        'name.required' => '名称为必填!',
        'phone.required'=>'手机号为必填',
        'message.max'=>'留言超过了最大限制',
    ];
    return $messages;
    }    
}
