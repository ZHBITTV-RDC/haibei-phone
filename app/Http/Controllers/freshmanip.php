<?php
define("TOKEN", "zhbittv");
header('Content-type:text/html;charset=utf-8');
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
                //libxml_disable_entity_loader(true);

              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //解析数据
                $this->fromUsername = $postObj->FromUserName;
                $this->toUsername = $postObj->ToUserName;
                $this->content = trim($postObj->Content);
                $time=time();
                //获得Post过来的数据
             //   $this->cheakid();
                //判断是否绑定账号
                if(!strcasecmp($this->content,"cxip")){
                    $this->ResContent="新生IP查询格式：\ncxip+栋数+宿舍号+床号\n例如:02栋607室3号床\n回复:cxip026073\n-----------------\n一小部分新生查询不到IP请移步到网络中心咨询\n老生请直接回复：ip"; 
                }else{
                    $this->GetIpInfo();
                    //查询IP
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


    private function cheakid(){
        $this->getsql('jiaowu');
        $sql = "SELECT * FROM bangding WHERE openid ='{$this->fromUsername}'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if(empty($row)){
            $this->note();
             mysql_close($this->link);
            exit;
        }else{
             mysql_close($this->link);
        }
       
    }


    private function note(){
        $fromUsername = $this->fromUsername;
        $toUsername = $this->toUsername;
        $time = time ();
        $cxurl=$this->cxurl;
        $content = "首次查询要先绑定学号才行喔！\n <a href=\"{$cxurl}bangding.php?id={$fromUsername}\">→点击绑定</a>";
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


    private function GetIpInfo(){
        if(strlen($this->content)==10){
            $BuildNo=intval(substr($this->content, 4,2),10);
            //转为整形
            $DorNo=substr($this->content,6,3);
        }else{
            $BuildNo=substr($this->content, 4,1);
            $DorNo=substr($this->content,5,3);
        }
        $BedNo=substr($this->content,-1,1);
        $this->getsql("ip");
        $sql = "SELECT * FROM newip WHERE BuildNo='{$BuildNo}' AND DorNo='{$DorNo}' AND BedNo='{$BedNo}'";
        $result = mysql_query($sql);
        if($row = mysql_fetch_assoc($result))
        {
            $this->ResContent="{$BuildNo}栋{$DorNo}室{$BedNo}号床\n-----------------\nIP\n{$row['IP']}\n子网掩码\n{$row['Subnet']}\n网关\n{$row['Gateway']}\nDNS\n{$row['DNS']}\n备用DNS\n{$row['BDNS']}\n-----------------\n如IP地址有误\n请咨询网络中心\n电话:0756-3832741\n电话:0756-3832748";
        }else{
            $this->ResContent="您查询的IP不存在或您的输入有误，请重新查询\n-----------------\n查询格式：\ncxip+栋数+宿舍号+床号\n例如:02栋607室3号床\n回复:cxip026073\n-----------------\n一小部分新生查询不到IP请移步到网络中心咨询\n老生请直接回复：ip";
        }
        mysql_close($this->link);
    }

}

?>