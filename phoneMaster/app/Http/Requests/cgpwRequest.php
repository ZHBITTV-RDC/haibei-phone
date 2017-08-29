<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class cgpwRequest extends Request
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
              'password'=>'required|alpha_num|Max:16',
              'newPassword'=>'alpha_num|Max:16',
            
        ];
    }

public function messages(){
    return [
        'password.required'=>'原始密码不能为空',
        'newPassword.alpha_num'=>'密码只能为数字或者字母',
        'newPassword.max'=>'密码不能超过16个字符',

     ];
  } 

}
