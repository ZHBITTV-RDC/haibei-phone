<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lecture extends Model
{
	//指定表名
    protected $table='lecture';

    //指定主键
    protected $primaryKey='id';

    //设置允许批量赋值的字段
    protected  $fillable=[];

    //是否时间自动维护
     public $timestamps=true;

     //指定不允许批量赋值的字段
     protected $guarded=[];

     //将时间变为时间戳
     // protected function getDateFormat(){

     // 	return time();
     // }
     //关闭自动格式化时间戳
     // protected function asDateTime($val){
     // 	return $val;
     // }


}
