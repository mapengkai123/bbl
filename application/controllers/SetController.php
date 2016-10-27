<?php
/**
 * Created by PhpStorm.
 * User: 元宝
 * Date: 2016/10/15
 * Time: 9:30
 */

namespace application\controller;

use core\lib\Ecd;
use application\models\userModel;

class SetController  extends \core\imooc
{
    /*
     * 设置主页
     */
    public function home()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $model = new userModel();
            $res = $model->getone('user_info', ['u_id' => $id]);
            $result['name'] = $res['realname'];
            $result['phone'] = substr_replace($res['phone'], '****', 3, 4);
            $this->assign("one", $result);
            $this->display('set.php');
        }
    }

    /*
    * 实名认证
    */
    public function name()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_ren.php');
        }
    }

    /*
   * 银行卡
   */
    public function bank()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_bank.php');
        }
    }

    /*
     * 添加银行卡页面
     */
    public function add_bank()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_gobank.php');
        }
    }

    /*
     * 我的订单
     */
    public function order()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_order.php');
        }
    }

    /*
     * 个人信息
     */
    public function info()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $model = new userModel();
            $res = $model->getone("user_info", ['u_id' => $id]);
            $this->assign("one", $res);
            $this->display('set_info.php');
        }
    }

    /*
     * 绑定手机
     */
    public function bang()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $model = new userModel();
            $res = $model->getone("user_info", ['u_id' => 1]);
            $this->assign("bang", $res);
            $this->display('set_bang.php');
        }
    }

    /*
     * 修改手机号页面
     */
    public function phone()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_phone.php');
        }
    }

    /*
    * 短信验证码
    */
    public function msg()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $tel = post('num');
            if (!preg_match("/^1[34578]{1}\d{9}$/", $tel)) {
                exit(1);
            }
            $rand = rand(10000, 999999);
            $url = "http://www.etuocloud.com/gatetest.action";
            $app_key = 'exdeaxIkNw0vgH1WNbifPpuXe6HICvQN';
            $app_secret = 'bVMnLnUz3KUltEpYLm3nwL5SXmyrEPpHDXff55YJjWdjn5j3f3ny49Y8Ez8zae0d';
            $format = 'json';
            //初始化
            $ecd = new Ecd($url, $app_key, $app_secret, $format);
            //发送验证码短信
            $res = $ecd->send_sms_code("$tel", "1", $rand, '');
            $json = json_decode($res, true);
            //var_dump($json);die;
            if ($json['result'] == 0) {
                $_SESSION['rand'] = $rand;
            } else {
                echo 2;
            }

        }
    }

    /*
     * 验证短信验证码
     */
    public function number()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $rand = $_SESSION['rand'];
            echo $rand;
        }
    }

    /*
     * 修改手机号
     */
    public function setphone()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $phone = post('phone');
            $model = new userModel();
            $res = $model->save('user_info', ['phone' => $phone], ['u_id' => $id]);
            if ($res) {
                jump('Set/bang');
            }
        }
    }


    /*
   * 交易密码
   */
    public function pass()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_pass.php');
        }
    }

    /*
     * 设置交易密码页面
     */
    public function gopass()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $model = new userModel();
            $res = $model->getone('user_info', ['u_id' => $id]);
            $result['tel'] = $res['phone'];
            $result['phone'] = substr_replace($res['phone'], '****', 3, 4);
            $this->assign('sj', $result);
            $this->display('set_gopass.php');
        }
    }

    /*
      * 设置交易密码
      */
    public function set_gopass()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $pass = post('pass');
            $paypass = MD5($pass);
            $model = new userModel();
            $res = $model->save('user_info', ['paypass' => $paypass], ['u_id' => $id]);
            if ($res) {
                jump('Set/pass');
            }
        }
    }

    /*
     * 交易旧密码
     */
    public function old()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $jps = post('jps');
            $model = new userModel();
            $res = $model->getone('user_info', ['u_id' => $id]);
            $pass = $res['paypass'];
            $old = MD5($jps);
            if ($pass == $old) {
                echo 1;
            }
        }
    }

    /*
    * 修改登陆密码页面
    */
    public function topass()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $model = new userModel();
            $res = $model->getone('user_info', ['u_id' => $id]);
            $result['tel'] = $res['phone'];
            $result['phone'] = substr_replace($res['phone'], '****', 3, 4);
            $this->assign('sj', $result);
            $this->display('set_topass.php');
        }
    }

    /*
    * 修改登录密码页面
    */
    public function pwd()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $model = new userModel();
            $res = $model->getone('user_info', ['u_id' => $id]);
            $result['tel'] = $res['phone'];
            $result['phone'] = substr_replace($res['phone'], '****', 3, 4);
            $this->assign('sj', $result);
            $this->display('set_pwd.php');
        }
    }

    /*
      * 修改登陆密码
      */
    public function set_topass()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $pwd = post('pwd');
            $npass = MD5($pwd);
            $model = new userModel();
            $res = $model->save('user', ['u_pwd' => $npass], ['u_id' => $id]);
            if ($res) {
                jump('Set/pwd');
            }
        }
    }

    /*
    * 登陆旧密码
    */
    public function old_pwd()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $jps = post('pwd');
            $model = new userModel();
            $res = $model->getone('user', ['u_id' => $id]);
            $pwd = $res['u_pwd'];
            $old = MD5($jps);
            if ($pwd == $old) {
                echo 1;
            }
        }
    }

    /*
     * 常见问题
     */
    public function ques()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_ques.php');
        }
    }

    /*
    * 关于我们
    */
    public function details()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $this->display('set_details.php');
        }
    }

    /*
     * 退出登陆
     */
    public function out()
    {
        //注销登录
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        session_destroy();
        jump('/');
        exit;
    }

    /*
     * 修改昵称
     */
    public function change()
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if ($id == 0) {
            jump('Login/login');
        } else {
            $nick = post('title');
            $model = new userModel();
            $result = $model->save('user_info', ['nickname' => $nick], ['u_id' => $id]);
            if ($result) {
                echo 1;
            }
        }
    }

    /** 上传头像
     * @param Request $request
     */
    public function img()
    {
        $file = $_FILES['photoimg'];
        //var_dump($file);die;
        $type = substr($file['name'], strrpos($file['name'], '.') + 1);
        $size = $file['size'];
        $valid_formats = array("jpg", "png", "gif", "bmp");
        if (!in_array($type, $valid_formats)) {
            echo "图片格式不符合要求";
            exit;
        }
        //ku
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        $model = new userModel();
        $resume = $model->getone('user_info', ['u_id' => $id]);
        //拼接图片地址
        $data['img'] = './public/uploads/' . rand(0, 999).'.' .$type;
        move_uploaded_file($file['tmp_name'], $data['img']);
        //判断图片是否存在,进行删除替换
        if (file_exists($resume['img'])) {
            unlink($resume['img']);
        };
//        $res = Resume::updateResume($data, ['u_id' => $id]);
        $res = $model->save('user_info', $data, ['u_id' => $id]);
        if ($res) {
            return $data['img'];
        } else {
            return $data['img'];
        }

    }



}


