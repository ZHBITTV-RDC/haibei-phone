<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if($_GET['echostr']){
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    private $fromUsername;
    private $toUsername;
    private $content;
    private $link;  //数据库连接
    private $ResContent;  //返回数据
    private $NO;


	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
               // libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                 $this->fromUsername = $postObj->FromUserName;
                $this->toUsername = $postObj->ToUserName;
                $this->content = trim($postObj->Content);
                $time=time();
                if($this->content=='jz'||$this->content=='JZ'||$this->content=='讲座'||$this->content=='形势与政策'||$this->content=='形势与政策讲座'){
                    $this->ResContent="查询形势与政策讲座\n请回复:jz+学号\n例：jz+150000000000";
                }else{
                    if(preg_match_all("/\+/",$this->content,$arr)&&sizeof($arr[0])==1){
                        $arr=explode('+', $this->content);
                        $this->NO=$arr[1];
                        $this->lecture();
                    }else{
                        $this->ResContent="您的输入有错哦(ÒωÓױ)！！！\n-----------------\n正确的输入方法为：jz+学号\n例：jz+150000000000";
                    }
                }
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				$msgType = "text";
                $resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername,$time, $msgType, $this->ResContent);
                echo $resultStr;

        }else {
        	echo "连接成功";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}



    private function getsql($dbname){
        $host ="localhost";
        $port ="3306";
        $user ="root";//这里填写你用户名
        $pwd ="ZHBITTV!@#$";//这里填写你数据库密码

        /*接着调用mysql_connect()连接服务器*/
        $this->link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
        if(!$this->link) {
                    die("Connect Server Failed: " . mysql_error($this->link));
                   }
        /*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
        if(!mysql_select_db($dbname,$this->link)) {
                    die("Select Database Failed: " . mysql_error($this->link));
                   }
        mysql_query("set names utf8");
    }

    private function lecture(){
        $this->getsql('lecture');
        $sql="select * from lecture where StudentNO={$this->NO}";
        $rst=mysql_query($sql);
        $sum=0;
        while($row=mysql_fetch_assoc($rst)){
            if($row['StudentNO']!=NULL){
                if(!$sum)
                    $this->ResContent=$row['Name']."同学已听过的讲座"."\n-----------------\n";
                $this->ResContent.=$row['LectureName']."\n时间：".$row['Time']."\n-----------------\n";
                $sum++;
            }
        }
        if ($this->ResContent==NULL) {
            $this->ResContent="(´•灬•‘)很抱歉，小贝找不到您的记录，请您移步到<a href=\"http://sz.zhbit.com/\">→这里查询</a>\n-----------------\n讲座信息更新到:【2017年6月12日前】，小贝会及时与马克思主义学院发布的信息同步✧*。٩(ˊωˋ*)و✧*。\nBY 海贝TV 研发部";
        }else{
            $this->ResContent.="您一共听了".$sum."场讲座"."\n-----------------\n注:讲座信息更新到:【2017年6月12日前】，小贝会及时与马克思主义学院发布的信息同步。极少部分同学如果数据有误，请<a href=\"http://sz.zhbit.com/\">→点击这里</a>，进行查询✧*。٩(ˊωˋ*)و✧*。\n BY 海贝TV 研发部";
        }
    }


}

?>