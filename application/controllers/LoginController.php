<?php

namespace application\controller;

use application\models\userModel;
use core\lib\Ecd;

class LoginController extends \core\imooc
{

    /*
     * 登陆首页
     */
    public function login()
    {
        $this->display('login1.php');
    }

    /*
     * 验证登陆
     */
    public function logined()
    {
        //接值
        $name = post('name');
        $pwd = MD5(post('u_pwd'));
//       echo  $name,$pwd;die;
        $model = new userModel();
        $login = $model->where("user", ["u_name" => "$name", "u_pwd" => "$pwd"]);
//         var_dump($login);die;
        if ($login) {
            $_SESSION['id']=$login[0]['u_id'];
            $_SESSION['name']=$name;
           jump('/');
        } else {
            echo "<script>alert('登陆失败');history.go(-1);</script>";
        }
    }

    /*
     * 注册页
     */
    public function reg()
    {
        $this->display('register.php');
    }

    /*
     * 验证注册
     */
    public function register()
    {
        //接值
        $name1="/^[a-z]{3,10}$/i";
        $name = post('u_name');
        if (!preg_match($name1, $name)) {
            echo "<script>alert('注册失败');history.go(-1);</script>";
            return FALSE;
        }

        $pwd1="/^[0-9]{6,10}$/";
        $pwd = post('u_pwd');
        if (!preg_match($pwd1, $pwd)) {
            echo "<script>alert('注册失败');history.go(-1);</script>";
            return FALSE;
        }

        $email1="/^[\w]+(\.[\w]+)*@[\w]+(\.[\w]+)+$/";
        $email = post('email');
        if (!preg_match($email1, $email)) {
            echo "<script>alert('注册失败');history.go(-1);</script>";
            return FALSE;
        }

        $phone1="/^1(3|4|5|8|7)\d{9}$/";
        $phone = post('phone');
        if (!preg_match($phone1, $phone)) {
            echo "<script>alert('注册失败');history.go(-1);</script>";
            return FALSE;
        }

        $nickname = post('nickname');
        if($nickname==''){
            echo "<script>alert('注册失败');history.go(-1);</script>";
            return FALSE;
        }


        $time=date('Y-m-d H:i:s',time());
        $model = new userModel();
        $jia=$model->add('user',['u_name'=>$name,'u_pwd'=>md5($pwd)]);

          if ($jia) {
              $model->add('user_info', ['u_id' => $jia, 'nickname' => $nickname, 'email' => $email, 'phone' => $phone,'regtime'=>$time]);
              jump('Login/login');

          }
    }

    /*
     * 验证账号唯一性
     */
    public function only(){
        $name=post('name');
        $model=new userModel();
        $one=$model->getone('user',['u_name'=>$name]);
        if($one==true){
            echo 1;
        }
    }
    /*
     * 短信验证码
     */
    public function msg(){
            //var_dump($_SERVER);die;
            $tel=post('num');
        if(!preg_match("/^1[34578]{1}\d{9}$/",$tel)) {
            exit(1);
        }
            $rand=rand(10000,999999);
            $url = "http://www.etuocloud.com/gatetest.action";
            $app_key = 'exdeaxIkNw0vgH1WNbifPpuXe6HICvQN';
            $app_secret = 'bVMnLnUz3KUltEpYLm3nwL5SXmyrEPpHDXff55YJjWdjn5j3f3ny49Y8Ez8zae0d';
            $format = 'json';
            //初始化
            $ecd = new Ecd($url,$app_key,$app_secret,$format);
            //发送验证码短信
            $res= $ecd->send_sms_code("$tel","1",$rand,'');
            $json=json_decode($res,true);
            //var_dump($json);die;
            if($json['result']==0){
                $_SESSION['rand']=$rand;
            }else{
                echo 2;
            }

    }
    /*
     * 验证短信验证码
     */
    public function number(){
        $rand=$_SESSION['rand'];
        echo $rand;
    }
}

