<?php 

// php头文件
 header('content/type:text/html;charset="utf-8"');
 
 $arr = array(
    
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容1'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容2'),
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容3'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容4'),
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容5'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容6'),
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容7'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容8'),
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容9'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容10'),
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容11'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容12'),
    array('src' => 'img/index.png' , 'title' => '视频三' , 'content' => '内容13'),
    array('src' => 'img/index.png' , 'title' => '视频四' , 'content' => '内容14'),
 	);
  $n = $_POST['n'];
 $l = $_POST['l'];
 //将数组转化为json格式，json_encode()是php函数
 $array = array();
 
 for($j=$n;$j<$l;$j++){
    array_push($array,$arr[$j]);
 }
 
 $a = json_encode($array,true);
 echo $a;
 ?>