<?php

namespace core\lib;


use core\lib\model;

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$RX_TYPE = trim($postObj->MsgType);

				switch($RX_TYPE)
				{
					case "text":
						$resultStr = $this->handleText($postObj);
						break;
					case "event":
						$resultStr = $this->handleEvent($postObj);
						break;
					default:
						$resultStr = "Unknow msg type: ".$RX_TYPE;
						break;
				}
				echo $resultStr;
		}else{
			echo "";
			exit;
		}
	}

    public function handleText($postObj)
    {     
        $keyword = trim($postObj->Content);
        if(!empty( $keyword ))
        {
            $content = '李智渊';
            return $this->texttemplate($postObj,$content);
        }
    }

    
    private function handleEvent($postObj)
    {
    	
        switch ($postObj->Event)
        {
            case "subscribe":
            	$content =  "欢迎关注帮帮乐";
                $result = $this->texttemplate($postObj,$content);
                break;
            case "CLICK":   //这里是大写‘CLICK’
                $result = $this->usertemplate($postObj,$postObj->EventKey);
                break;
        }
        
        return $result;
    }

    public function usertemplate($postObj,$type){
        switch ($type) {
        	case 'userinfo':
        		$openid = $postObj->FromUserName;;
        		$result = $this->userinfotmp($openid);
        		break;
        	
        	default:
        		# code...
        		break;
        }
        return $result;
    }

    public function userinfotmp($openid){
    	$model = new model();
    	$res = $model->get('user','*',['open_id'=>"$openid"]);
    	if($res!=false){
    		$info = $model->get('user_info','*',['u_id'=>$res['u_id']]);
    		$json = '{
           	"touser":"'.$openid.'",
           	"template_id":"DSwCc6CNn2JxyW23l-b2fWiAF-Ok6ntm4rdHqeYnbwA",           
           	"data":{
                   "frist": {
                       "value":"您已成功绑定帮帮乐账号",
                       "color":"red"
                   },
                   "keywords1":{
                       "value":"'.$res['u_name'].'",
                       "color":"#173177"
                   },
                   "keywords2": {
                       "value":"'.$info['nickname'].'",
                       "color":"#173177"
                   },
                   "keywords3": {
                       "value":"'.$info['regtime'].'",
                       "color":"#173177"
                   },
                   "keywords4": {
                       "value":"'.$info['lastlogintime'].'",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"感谢您的查询",
                       "color":"red"
                   }
           		}
       		}';
    	}else{
    		$json = '{
           	"touser":"'.$openid.'",
           	"template_id":"DSwCc6CNn2JxyW23l-b2fWiAF-Ok6ntm4rdHqeYnbwA",
           	"url":"http://bbl.lzyapp.cn/wechat/bangding",            
           	"data":{
                   "frist": {
                       "value":"您未绑定帮帮乐账号",
                       "color":"red"
                   },
                   "keywords1":{
                       "value":"*****",
                       "color":"#173177"
                   },
                   "keywords2": {
                       "value":"*****",
                       "color":"#173177"
                   },
                   "keywords3": {
                       "value":"*****",
                       "color":"#173177"
                   },
                   "keywords4": {
                       "value":"*****",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"请绑定您的帮帮乐账号",
                       "color":"red"
                   }
           		}
       		}';
    	}
    	$token = $this->getToken();
    	$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$token;
    	$this->curlPost($url, $json);
    	return '';
    	  	
    }

    private function texttemplate($postObj,$content){
    	$fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>";
         
        $msgType = "text";
        return sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $content);
    }

    public function getToken(){

        if(!isset($_SESSION['token'])){

            $appid = "wxa838acab05c50364";
            $seciet = "a7eed6e2296d3e7d34391eb95af4efd0";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$seciet;
            $file = file_get_contents($url);
            $arr = json_decode($file, true);
            $_SESSION['token'] = $arr['access_token'];
        }
        return $_SESSION['token'];
    }

    public function checkmenu($json){

        if(!empty($json)){
            $token = $this->getToken();
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
            return $this->curlPost($url, $json);
        }

        return false;
     
    }

    private function curlPost($url,$data,$method='POST'){  
        $ch = curl_init();   //1.初始化  
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式  
        //4.参数如下  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');//模拟浏览器  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);  
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));//gzip解压内容  
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');  
          
        if($method=="POST"){//5.post方式的时候添加数据  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        }  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $tmpInfo = curl_exec($ch);//6.执行  
      
        if (curl_errno($ch)) {//7.如果出错  
            return curl_error($ch);  
        }  
        curl_close($ch);//8.关闭  
        return $tmpInfo;  
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
}
