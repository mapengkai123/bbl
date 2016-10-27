<?php

namespace application\controller;

use application\models\signInModel;
class SignInController extends \core\imooc
{
	/**
     * 签到首页
     * @return [type] [description]
     */
    public function show()
    {
        if(isset($_SESSION['id']))
        {
            $this->display('sign_in/show.php');
        }else{
            $this->display('login1.php');
        }
    }

    /**
     * 添加入库
     */
    public function add()
    {
        $u_id = $_SESSION['id'];
        $signIn = new signInModel();
        $date = $signIn->add($u_id);
        echo json_encode($date);
    }

    /**
     * 获取页面签到次数
     */
    public function xiangqing()
    {
        $u_id = $_SESSION['id'];
        $signIn = new signInModel();
        $num = $signIn->num($u_id);
        echo json_encode($num);
    }

    /**
     * 签到次数兑换奖品
     */
    public function exchange()
    {
        $u_id = $_SESSION['id'];
        $id = get('id');
        $signIn = new signInModel();
        $bool = $signIn->exchange($id,$u_id);
        echo $bool;
    }

    /**
     * 个人奖品页
     */
    public function price()
    {
        $this->display('sign_in/price.php');
    }

    /**
     * 奖品列表
     */
    public function price_list()
    {
        $u_id = $_SESSION['id'];
        $signIn = new signInModel();
        $data = $signIn->price_list($u_id);
        echo json_encode($data);
    }
}