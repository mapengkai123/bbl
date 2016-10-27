<?php

namespace application\controller;

use core\lib\wechatCallbackapiTest;
use core\lib\model;

class WechatController extends \core\imooc
{

    public function check()
    {
        define("TOKEN",'lzy123');
        $wechat = new wechatCallbackapiTest();
        $wechat->responseMsg();
    }

    public function updatamenu()
    {
        $json = '{
                    "button":[
                    {  
                        "type":"view",
                        "name":"帮帮乐",
                        "url":"http://bbl.lzyapp.cn/wechat/welogin"
                    },
                    {
                        "name":"我的",
                        "sub_button":[
                        {    
                            "type":"click",
                            "name":"个人信息",
                            "key":"userinfo"
                        },
                        {    
                            "type":"view",
                            "name":"签到",
                            "url":"http://bbl.lzyapp.cn/signIn/show"
                        },
                        {
                            "type":"click",
                            "name":"订单",
                            "key":"order"
                        },
                        {
                            "type":"click",
                            "name":"充值",
                            "key":"chongzhi"
                        },
                        {
                            "type":"click",
                            "name":"提现",
                            "key":"cash"
                        }]
                   },
                   {
                       "name":"更多",
                       "sub_button":[
                       {    
                            "type":"view",
                            "name":"绑定账号",
                            "url":"http://bbl.lzyapp.cn/wechat/bangding"
                        },
                        {
                            "type":"click",
                            "name":"帮助",
                            "key":"help"
                        },
                        {
                            "type":"click",
                            "name":"关于我们",
                            "key":"we"
                        }]
                    }]
                }';
        $wechat = new wechatCallbackapiTest();
        $res = $wechat->checkmenu($json);
        $res = json_decode($res,true);
        if($res['errcode']==0){
            echo "修改菜单成功";
        }else{
            echo "失败";
        }
    }

    public function welogin()
    {
         //检测是否是微信浏览器
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            // $url = urlencode("http://bbl.lzyapp.cn");
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa838acab05c50364&redirect_uri=http%3A%2F%2Fbbl.lzyapp.cn%2Fwechat%2Fwelog&response_type=code&scope=snsapi_base&state=lzy123#wechat_redirect";
            header("Location:".$url);
        }   
    }

    public function welog(){
            $APPID='wxa838acab05c50364';
            $SECRET='a7eed6e2296d3e7d34391eb95af4efd0';
            $state='lzy123';
            $code='';
            if($_GET['state']==$state){
                $code = $_GET['code'];
                $uinfo=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$APPID."&secret=".$SECRET."&code={$code}&grant_type=authorization_code");
                $uinfo=json_decode($uinfo,true);
                $openid=$uinfo['openid'];
                $model = new model();
                $info = $model->get("user",'u_id',['open_id'=>$openid]);
                if($info!=false){
                    $_SESSION['id'] = $info['u_id'];
                }
                jump('/');
            }
    }

    public function bangding(){
         //检测是否是微信浏览器
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa838acab05c50364&redirect_uri=http%3A%2F%2Fbbl.lzyapp.cn%2Fwechat%2Fwebangding&response_type=code&scope=snsapi_base&state=lzy123#wechat_redirect";
            header("Location:".$url);
        }else{
            echo "请用微信浏览器打开本页面";
        }
    }

    public function webangding(){
        $APPID='wxa838acab05c50364';
        $SECRET='a7eed6e2296d3e7d34391eb95af4efd0';
        $state='lzy123';
        $code='';
        if($_GET['state']==$state){
            $code = $_GET['code'];
            $uinfo=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$APPID."&secret=".$SECRET."&code={$code}&grant_type=authorization_code");
            $uinfo=json_decode($uinfo,true);
            $openid=isset($uinfo['openid'])?$uinfo['openid']:false;
            if ($openid!=false) {
            	$model = new model();
                $info = $model->get("user",'u_id',['open_id'=>$openid]);
                if($info!=false){
                    $_SESSION['id'] = $info;
                    jump("/");
                }else{
                	$this->assign('openid',$openid);
                	$this->display('bangding.php');
                }
                
            }else{
                echo "本页面刷新无效";
            }
            
           
        }
    }

    public function bangdingac(){
        $name = post('name');
        $pwd = MD5(post('u_pwd'));
        $openid = post('openid');
        $model = new Model();
        $login = $model->get("user",'*', ['AND'=>["u_name" => "$name","u_pwd" => "$pwd"]]);
        if ($login) {
           $re = $model->update('user',['open_id'=>$openid],['u_id'=>$login['u_id']]);
           $_SESSION['id']=$login['u_id'];
            jump('/');
        } else {
            $this->assign('openid',$openid);
            $this->assign('msg',"账号或密码错误");
            $this->display('bangding.php');
        }

    }
}
