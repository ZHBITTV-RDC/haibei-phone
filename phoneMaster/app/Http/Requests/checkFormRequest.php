<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class checkFormRequest extends Request
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
                //标题必须输入
                'title'=>'required',
                //限制内容长度
                'data'=>'Max:1000', 
                //类别必须选择
                'class'=>'required',
                'abstract'=>'required',

          ];
    }

    //重写messages方法 自定义错误信息
    public function messages(){
    return [
        'title.required' => '标题不能为空',
        'data.Max:1000'  => '内容长度超过限制',   
        'class.required'=> '请选择视频的分类',
        'abstract.required'=>'简介要填写哦',
    ];

   }
}
