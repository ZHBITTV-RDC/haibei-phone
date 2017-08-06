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
    private $cxurl="http://tv.zhbit.com/jiaowutest/"; //这里填写文件所在目录，末尾一定要加 "/"
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
                $arr=explode('+', $this->content);
                $this->NO=$arr[1];
                echo $this->NO;
                $this->lecture();
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
        $pwd ="admin";//这里填写你数据库密码

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
            if(!$sum)
                $this->ResContent=$row['Name']."同学已听过的讲座"."\n----------------\n";
            $this->ResContent.=$row['LectureName']."\n时间：".$row['Time']."\n----------------\n";
            $sum++;
        }
        $this->ResContent.="您一共听了".$sum."场讲座"."\nby 海贝TV 研发部";
    }


}

?>