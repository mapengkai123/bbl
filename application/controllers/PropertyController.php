<?php

namespace application\controller;

use application\models\userInfoModel;

class PropertyController extends \core\imooc
{
    /**
     * 充值视图
     */
    public function recharge()
    {
        $this->display('recharge.php');
    }

    /**
     * 充值动作
     */
    public function recharge_ac()
    {
        //检测登录
        $_SESSION['user'] = 1;

        $user = $_SESSION['user'];
        $paynum = post('paynum',false,'int');
        $type = post('type',false,'int');
        $paypass = post('paypass',false,'int');
        $info = array();
        if(!$paynum || !$type || !$paypass) {
            $info['status'] = 0;
            $info['msg'] = '您的信息填错啦！';
        } else {
            $model = new userInfoModel();
            $passwd = md5(md5($paypass));
            //验证支付密码
            $re = $model->checkPayPass($user,$passwd);
            if(!$re['status']) {
                $info['status'] = 0;
                $info['msg'] = $re['msg'];
            } else {
                if( $model->recharge($user,$paynum) ) {
                    $info['status'] = 1;
                    $info['msg'] = '成功充值' . $paynum . '元';
                } else {
                    $info['status'] = 1;
                    $info['msg'] = 'sorry! 充值失败了';
                }
            }
        }
        $this->assign('info',$info);
        $this->display('prompl.php');
    }

    /**
     * 提现视图
     */
    public function cash()
    {
        $u_id = 1;
        $model = new userInfoModel();
        $re = $model->getBalance($u_id);
        $this->assign('price',$re);
        $this->display('cash.php');
    }

    /**
     * 提现动作
     */
    public function cash_ac()
    {
        //检测登录
        $_SESSION['user'] = 1;

        $user = $_SESSION['user'];
        $balance = post('balance',false,'int');
        $luhm = post('luhm',false,'int');
        $paypass = md5(md5(post('paypass',false,'int')));
        $model = new userInfoModel();
        $price = $model->getBalance($user);
        if(!$balance || !$luhm || !$paypass) {
            $info['status'] = 0;
            $info['msg'] = '您的信息填错啦！';
        } elseif($balance>$price) {
            $info['status'] = 0;
            $info['msg'] = '您没有这么多钱！';
        } elseif(!luhmCheck($luhm)) {
            $info['status'] = 0;
            $info['msg'] = '您的银行卡错误！';
        } else {
            $re = $model->checkPayPass($user,$paypass);
            if(!$re['status']) {
                $info['status'] = 0;
                $info['msg'] = $re['msg'];
            } else {
                $re = $model->cash($user,$balance);
                if($re) {
                    $info['status'] = 1;
                    $info['msg'] = '提现成功！';
                } else {
                    $info['status'] = 0;
                    $info['msg'] = '提现失败！';
                }
            }
        }
        $this->assign('info',$info);
        $this->display('cashinfo.php');
    }
}