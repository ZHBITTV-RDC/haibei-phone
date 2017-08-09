<?php

namespace App\Classes;

use Config;
use App\web_bangding;
/**
 * Created by PhpStorm.
 * User: shq
 * Date: 2016/6/14
 * Time: 15:58
 */
class JwWechat
{
    private $cookie_file;
    private $jwurl;
    private $fromUsername;
    private $toUsername;

    public $link;

    function __construct(){
        $this->cookie_file = tempnam('./temp', 'cookie');
        $this->jwurl = Config::get('constants.JWURL');

    }

    function __destruct() {
        @unlink($this->cookie_file); //删除cookie
        @mysql_close($this->link);
    }
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature())
        {
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature )
        {
            return true;
        }else{
            return false;
        }
    }

    private function getsql()
    {
        /*接着调用mysql_connect()连接服务器*/
        $this->link = $link = @mysql_connect(DB_HOST.':'.DB_PORT,DB_USER,DB_PWD,true);
        if(!$link)
        {
            die("Connect Server Failed: " . mysql_error($link));
        }
        if(!mysql_select_db(DB_NAME,$link)) {
            die("Select Database Failed: " . mysql_error($link));
        }
        mysql_query("set character set 'utf8'");
        return $link;
    }


    public function getUserinfo($openid = null)
    {
        $openid = (isset($openid)) ? $openid : $this->fromUsername;
        $con = $this->getsql();
        $res = mysql_query("SELECT * FROM bangding WHERE openid = '{$openid}'");
        $userinfo = mysql_fetch_array($res);
        if(empty($userinfo)){
            $this->text("首次查询要先绑定学号才行喔！\n <a href=\"".Config::get('constants.JwDir')."bangding.php?id={$openid}\">→点击绑定</a>");
            exit;
        }
        return $userinfo;
    }

    private function charCodeAt($str,$index = 1,$from_encoding=false)
    {
        $index++;
        if($index > strlen($str)){ return null;}
        $from_encoding=$from_encoding ? $from_encoding : 'UTF-8';

        if(strlen($str)==1){ return ord($str);}


        $str=mb_convert_encoding($str, 'UCS-4BE', $from_encoding);
        $tmp=unpack('N*',$str);
        return $tmp[$index];
    }

    private function encodeInp($input)
    {
        $keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        $output = "";
        $i = 0;
        $len = strlen($input);
        do {
            $chr1 = $this->charCodeAt($input, $i++);
            $chr2 = $this->charCodeAt($input, $i++);
            $chr3 = $this->charCodeAt($input, $i++);
            $enc1 = $chr1 >> 2;
            $enc2 = (($chr1 & 3) << 4) | ($chr2 >> 4);
            $enc3 = (($chr2 & 15) << 2) | ($chr3 >> 6);
            $enc4 = $chr3 & 63;
            if (!is_numeric($chr2)) {
                $enc3 = $enc4 = 64;
            } else if (!is_numeric($chr3)) {
                $enc4 = 64;
            }
            $output = $output . $keyStr{$enc1} . $keyStr{$enc2} . $keyStr{$enc3} . $keyStr{$enc4};
            $chr1 = $chr2 = $chr3 = "";
            $enc1 = $enc2 = $enc3 = $enc4 = "";
        } while ($i < $len);
        return $output;
    }




    public function getKeyword()
    {
        //get post data, May be due to the different environments
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = trim($postObj->MsgType);
            if($msgType == 'event'){
                $keyword = trim($postObj->EventKey);
            }else{
                $keyword = trim($postObj->Content);
            }
            $this->fromUsername = $postObj->FromUserName;
            $this->toUsername = $postObj->ToUserName;
            return $keyword;
        }else {
            echo "微信对接教务系统正常";
            exit;
        }
    }




    private function text($content) {
        $fromUsername = $this->fromUsername;
        $toUsername = $this->toUsername;
        $time = time ();
        $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";
        $msgType = "text";
        $contentStr = $content;
        $resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
        echo $resultStr;
    }


    private function Login($jwid,$jwpwd)
    {
        $jwurl=$this->jwurl;
        $encoded = $this->encodeInp($jwid).'%%%'.$this->encodeInp($jwpwd);
        $cookie_file = $this->cookie_file;

        $ch=curl_init($jwurl);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        $str=curl_exec($ch);
        $info=curl_getinfo($ch);
        curl_close($ch);

        $data = array(
            'userAccount'=>$jwid,
            'userPassword'=>$jwpwd,
            'encoded'=>$encoded
        );

        $login=http_build_query($data);
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,"{$jwurl}xk/LoginToXk");
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $login);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        $str=curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        //print_r($info);

        if($info['http_code'] != '302'){
            return false;
        }else{
            $ch=curl_init("{$jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);
            return true;
        }

    }

    private function get_kb_array($table) {
        $table = preg_replace("/<div id=\"([a-zA-Z]|\d)+-\d-\d\" +class=\"kbcontent1\".*?<\/div>/is","",$table); //删掉重复的课表部分
        $table = preg_replace("/<table[^>]*?>/is","",$table);
        $table = preg_replace("/<th[^>]*?>/si","",$table);
        $table = preg_replace("/<tr[^>]*?>/si","",$table);
        $table = preg_replace("/<td[^>]*?>/si","",$table);
        $table = str_replace("</tr>","{tr}",$table);
        $table = str_replace("</th>","{td}",$table);
        $table = str_replace("</td>","{td}",$table);
        $table = str_replace("\n","",$table);
        $table = str_replace("<br><br>","\n\n",$table);
        $table = str_replace("<br>","\n",$table);
        $table = str_replace("<br/>","\n",$table);
        //去掉 HTML 标记
        $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
        //去掉空白字符
        $table = preg_replace("'([rn])[s]+'","",$table);
        $table = str_replace(" ","",$table);
        $table = str_replace(" ","",$table);
        $table = str_replace("&nbsp;","",$table);

        $table = explode('{tr}', $table);
        array_pop($table);
        foreach ($table as $key=>$tr) {
            $td = explode('{td}', $tr);
            $td = explode('{td}', $tr);
            array_pop($td);
            $td_array[] = $td;
        }
        return $td_array;
    }

    public function getSchedule($jwid , $jwpwd)
    {
        if($this->Login($jwid,$jwpwd)) {

            $ch=curl_init("{$this->jwurl}xskb/xskb_list.do");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);

            $td = $this->get_kb_array($str);

            $d = (date('w') == 0)?7:date('w');
            $week=array('1'=>"星期一",'2'=>"星期二",'3'=>"星期三",'4'=>"星期四",'5'=>"星期五",'6'=>"星期六",'7'=>"星期日");
            for($i=2;$i<=8;$i++){
                if(trim($td[$i][$d]) == '') continue;
                $arr[]= trim($td[$i][0])."\n".trim($td[$i][$d]);
            }

            foreach($arr as $v){
                if(!empty($v)){
                    $kebiao .= "{$v}\n-----------------\n";
                }
            }
            $kebiao=trim($kebiao);
            $w=$week[$d];
            if(empty($kebiao)){
                $content = "你【{$w}】，你没有课哦。约上小伙伴去玩吧。\n-----------------\n";
            }else{
                $content = "你【{$w}】的课有：\n----------------\n".$kebiao."\n";
            }
            $cxurl=Config::get('constants.JwDir'); //教务的文件夹
            $content = $content."<a href=\"{$cxurl}Schedule.php?id={$this->fromUsername}\" >点我可以查看一周课表</a>";  //追加一周课表链接
            $this->text($content);	//这里修改图文和纯文字。text or news
            return $td;
        }else{
            $this->notice();
            return null;
        }
    }



    public function getAllSchedule($jwid , $jwpwd)
    {
        if($this->Login($jwid,$jwpwd)) {

            $ch=curl_init("{$this->jwurl}xskb/xskb_list.do");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);

            $td = $this->get_kb_array($str);

            for($i=2,$k=0;$i<=8;$i++,$k++) {
                for($j=1,$l=0;$j<=7;$j++,$l++){
                    $arr[$k][$l] = trim($td[$i][$j]);
                }
            }
            return $arr;
        }else{
            echo '登录失败';
            return null;
        }
    }



    public function getGrade($jwid,$jwpwd){
        if($this->Login($jwid,$jwpwd)) {
            $data = array(
                'kcmc'=>'',
                'kcxz'=>'',
                'kksj'=>'2016-2017-2',
                'xsfs'=>'a11'
            );
            $ch=curl_init("{$this->jwurl}kscj/cjcx_list");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);
            $ReContent=$this->getGradeInfo($str);
            if($ReContent=='请评教'){
                $ReContent="要先进入教务系统进行评教才能查询成绩哦！<a href=\"".$this->jwurl."xspj/xspj_find.do\">点击进行评教</a>✧٩(ˊωˋ*)و✧\nBY 海贝TV 研发部 ";
            }else{
                if (!$ReContent) {
                    $ReContent="本学期还未出成绩哦(ÒωÓױ)！！！<a href=\"".Config::get('constants.JwDir')."AllGrade.php?id={$this->fromUsername}\">点击查询全部成绩</a>✧٩(ˊωˋ*)و✧";
                }else{
                	preg_match_all("/<div id=\"Top1_divLoginName\".*>(.*)\(.*\)<\/div>/sU",$str,$table);
                    // print_r($table);
                    // $name=strip_tags($table[1][0]);
                    // $temp="{$name}的成绩"."\n-----------------\n";
                    // $ReContent.="<a href=\"".Config::get('constants.JwDir')."AllGrade.php?id={$this->fromUsername}&name={$name}\">点击查询全部成绩</a>"."\nBY 海贝TV 研发部";
                    // $temp.=$ReContent;
                    // $ReContent=$temp;
                }
            }
            return $ReContent;          
        }else{
            $this->notice();
            return null;
        }
    }

    public function getPreGrade($jwid,$jwpwd){
        if($this->Login($jwid,$jwpwd)) {
            $data = array(
                'kcmc'=>'',
                'kcxz'=>'',
                'kksj'=>'2016-2017-1',
                'xsfs'=>'a11'
            );
            $ch=curl_init("{$this->jwurl}kscj/cjcx_list");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);
            $ReContent=$this->getGradeInfo($str);
            if (!$ReContent) {
                $ReContent="查询不到您上学期的成绩哦(ÒωÓױ)！！！";
            }else{
                $ReContent.="回复\"成绩\"可以查询本学期成绩，回复\"全部成绩\"可查询全部成绩哦！✧٩(ˊωˋ*)و✧";
            }
            $this->text($ReContent);          
        }else{
            $this->notice();
            return null;
        }
    }    

    public function getAllGrade($jwid,$jwpwd){
        if($this->Login($jwid,$jwpwd)) {
            $data = array(
                'kcmc'=>'',
                'kcxz'=>'',
                'kksj'=>'',
                'xsfs'=>'a11'
            );
            $ch=curl_init("{$this->jwurl}kscj/cjcx_list");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);
            $ReContent=$this->getAllGradeInfo($str);
            return $ReContent;
            // if (!$ReContent) {
            //     $ReContent="本学期未出成绩哦(ÒωÓױ)！！！";
            // }else{
            //     $ReContent.="回复\"上学期成绩\"可以查询上学期成绩，回复\"成绩\"可查询本学期成绩哦！✧٩(ˊωˋ*)و✧";
            // }
            // $this->text($ReContent);          
        }else{
            $this->notice();
            return null;
        }
    }  

    private function getAllGradeInfo($str){      
        preg_match_all("/<tr>.*<\/tr>/sU",$str,$table);
        array_shift($table[0]);
        array_shift($table[0]);
        $j=0;
        foreach ($table as $key => $value) {
            foreach ($value as $key2 => $value2) {
                preg_match_all("/<td.*>.*<\/td>/",$value2,$show);
                if(strip_tags($show[0][3])){
                    for($i=0;$i<10;$i++){
                     $GradeInfo[$j][$i]=strip_tags($show[0][$i]);
                    }
                }
                $j++;
            }
        }
        preg_match_all("/平均学分绩点<span>(.*)。<\/span>/i",$str,$GAP);
        $GradeInfo[$j]=$GAP[1][0];
        return $GradeInfo; 
    }

    private function getGradeInfo($str){      
        preg_match_all("/<tr>.*<\/tr>/sU",$str,$table);
        array_shift($table[0]);
        array_shift($table[0]);
        $GradeInfo=array();
        $i=0;
        foreach ($table as $key => $value) {
            foreach ($value as $key2 => $value2) {
                preg_match_all("/<td.*>.*<\/td>/",$value2,$show);
                if(strip_tags($show[0][3])){
                $GradeInfo[$i]=strip_tags($show[0][3])."\n学分：".strip_tags($show[0][5])."\n成绩：".strip_tags($show[0][4]);
                $i++;
                    if(strip_tags($show[0][4])=='请评教'){
                        return '请评教';
                    }
                }
            }
        }
        return $GradeInfo; 
    }



    public function getExamTime($jwid,$jwpwd){
        if($this->Login($jwid,$jwpwd)) {
            $data = array(
                'xnxqid'=>'2016-2017-2',
                'xqlbmc'=>''
            );
            $ch=curl_init("{$this->jwurl}xsks/xsksap_list");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);
            $ReContent=$this->getExamTimeInfo($str);
            if (!$ReContent) {
                $ReContent="您本学期考试时间还未出哦，请耐心等待✧٩(ˊωˋ*)و✧";
            }else{
                //获取姓名
                preg_match_all("/<div id=\"Top1_divLoginName\".*>(.*)\(.*\)<\/div>/sU",$str,$table);
                print_r($table);
                $name=strip_tags($table[1][0]);
                $temp="{$name}的考试时间";
                $ReContent.="\n-----------------\n"."考试前极少部分考室可能会临时变更，请考试前再查询确认一遍\nBY 海贝TV 研发部";
                $temp.=$ReContent;
                $ReContent=$temp;
            }
            $this->text($ReContent);          
        }else{
            $this->notice();
            return null;
        }
    }



    private function getExamTimeInfo($str){
        preg_match_all("/<tr>.*<\/tr>/sU",$str,$table);
        array_shift($table[0]);
        array_shift($table[0]);
        foreach ($table as $key => $value) {
            foreach ($value as $key2 => $value2) {
                preg_match_all("/<td.*>.*<\/td>/",$value2,$show);
                if(strip_tags($show[0][3])){
                 $ExamTime.="\n-----------------\n"."科目:".strip_tags($show[0][3])."\n时间:".strip_tags($show[0][4])."\n考室:".strip_tags($show[0][5])."\n座位:".strip_tags($show[0][6]);
                }
            }
        }
        return $ExamTime;
    }

    public function getClass($jwid , $jwpwd)
    {
        if($this->Login($jwid,$jwpwd)) {

            $ch=curl_init("{$this->jwurl}grxx/xsxx");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_REFERER,"{$this->jwurl}framework/xsMain.jsp");
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
            $str=curl_exec($ch);
            curl_close($ch);
            preg_match_all('/<td align="center"  style="border:0px solid black" >(.*)<\/td>/i',$str,$info);
            // echo $info;
            $this->text($info[1][1]);
        }else{
            echo '登录失败';
            return null;
        }
    }



    public function getPassword($jwid,$jwpwd)
    {
        $content="您绑定的教务密码为:{$jwpwd}\n修改密码点击<a href=\"http://e.zhbit.com/jsxsd/\">进入教务系统</a>\n-----------------\n如有修改,请您修改后,请回复\"解绑\",然后回复\"绑定\"进行重新绑定。";
        $this->text($content);
    }



    public function bangding($userinfo = array()){
        $jwid = trim($userinfo['jwid']);
        $jwpwd = trim($userinfo['jwpwd']);
        $openid = $userinfo['openid'];
    
        // $this->getsql();
        // $sql = "SELECT * FROM bangding WHERE openid ='{$openid}'";
        // $model=M();//实例化
        // $row=$model->table('bangding')->where("openid='{$openid}'")->select();
        $row=web_bangding::where('opid','=',$openid)->first();
        // var_dump($userinfo);
        // $result = mysql_query($sql);
        // $row = mysql_fetch_array($result);
        if(!empty($row)){
            $arr=array('data'=>'你的微信已经绑定了学号。无法查询或修改密码后需重新绑定，回复：解绑');
            // echo  json_encode($arr);
            return 1;
        }else{
            if($this->Login($jwid,$jwpwd)){
                // $sql = "INSERT INTO `bangding`(`id`, `jwid`, `jwpwd`, `openid`) VALUES (null, '{$jwid}','{$jwpwd}','{$openid}')";
                // $Binding=$model->table('bangding')->where("openid='{$openid}'")->save($userinfo);
                $Binding=web_bangding::create(
                    [   
                        'opid'=>$openid,
                        'school_id'=>$jwid,
                        'school_pass'=>$jwpwd,
        
                    ]);
                if(!$Binding){
                    $arr=array('data'=>'未知原因，绑定失败，请重新尝试');
                    echo  json_encode($arr);
                } else {
                    $arr=array('data'=>'绑定成功, 返回海贝TV微信(zhbittv)，并回复“课表”、“成绩”、“考试”、“补考”来获取相应消息,<b>回复“密码”可查看自己的绑定密码。</b>');
                    // echo  json_encode($arr);
                    return 2;
                }
            }else{
                $arr=array('data'=>'用户名或密码错误，请重试');
                // echo  json_encode($arr);
                return 3;
            }
        }
    }

    public function bang(){
        $openid=$this->fromUsername;
        $this->getsql();
        $sql = "SELECT * FROM bangding WHERE openid ='{$openid}'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $jwid=$row['jwid'];
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if(!empty($row)){
            $this->text("你的微信已经绑定了学号{$jwid}\n\n若无法查询或修改密码后需重新绑定，请回复：解绑");
        }else{
            $this->text("首次查询要先绑定学号才行喔！\n <a href=\"".Config::get('constants.JwDir')."bangding.php?id={$openid}\">→点击绑定</a>");
        }
    }

    public function bangoff(){
        $openid=$this->fromUsername;
        $this->getsql();
        $sql = "SELECT * FROM bangding WHERE openid ='{$openid}'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $jwid=$row['jwid'];
        $sql = "DELETE FROM bangding WHERE openid ='{$openid}'";
        if(mysql_query($sql)){
            $this->text("你已经成功解除学号：{$jwid}的绑定！");
        }else{
            $this->text("未知原因，解绑失败，请重新尝试！");
        }
    }

    public function notice(){
        $this->text('用户名或密码错误，请回复“解绑”然后回复“绑定”进行重新绑定');
    }
}