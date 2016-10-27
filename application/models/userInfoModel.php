<?php
namespace application\models;

use core\lib\model;

class userInfoModel extends model
{
    private $table = 'user_info';

    /**
     * @param $u_id int 用户ID
     * @param $passwd string 输入的支付密码
     * @return array 支付状态 错误信息
     */
    public function checkPayPass($u_id,$passwd)
    {
        if(!is_numeric($u_id) || !is_string($passwd) || strlen($passwd)!=32) {
            $info['status'] = false;
            $info['msg'] = '请输入正确的参数';
        }
        $re = $this->get($this->table,['paypass','failnum','lastpaydate'],['u_id'=>$u_id]);
        //判断最后一次支付时间是不是今天
        if($re['failnum']>0 &&$re['lastpaydate']!=date('Y-m-d',time())) {
            $this->update($this->table,['failnum'=>0],['u_id'=>$u_id]);
        }
        //判断当天支付失败次数
        if($re['failnum']>=3 && $re['lastpaydate']==date('Y-m-d',time())) {
            $info['status'] = false;
            $info['msg'] = '今天支付密码输入错误已达三次！';
        } else {
            //支付密码错误失败次数加一 最后支付时间修改
            if ($re['paypass'] != $passwd) {
                $this->update($this->table, ['failnum[+]' => 1, 'lastpaydate' => date('Y-m-d', time())], ['u_id' => $u_id]);
                $info['status'] = false;
                $num = ($re['failnum'] + 1 >3)?1:$re['failnum'] + 1;
                $info['msg'] = '支付密码错误，输错' . $num . '次，三次后将不能支付';
                if ($num == 3) {
                    $info['msg'] = '今天支付密码输入错误已达三次！';
                }
            } else {
                $info['status'] = true;
                $info['msg'] = '支付密码正确';
            }
        }
        return $info;
    }

    /**
     * @param $u_id int 用户ID
     * @param $paynum int 充值数量
     * @return bool 充值成功或失败;
     */
    public function recharge($u_id,$paynum)
    {
        if(!is_numeric($u_id) || !is_numeric($paynum)) {
            return false;
        }
        $res = $this->update($this->table, ['balance[+]' => $paynum, 'lastpaydate' => date('Y-m-d', time())], ['u_id' => $u_id]);
        if ($res !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $u_id int 用户ID
     * @return array 可用余额
     */
    public function getBalance($u_id)
    {
        return $this->get($this->table,'balance',['u_id'=>$u_id]);
    }

    /**
     * @param $u_id int 用户ID
     * @param $paynum int 提现数量
     * @return bool 提现成功或失败;
     */
    public function cash($u_id,$balance)
    {
        if(!is_numeric($u_id) || !is_numeric($balance)) {
            return false;
        }
        $res = $this->update($this->table, ['balance[-]' => $balance, 'lastpaydate' => date('Y-m-d', time())], ['u_id' => $u_id]);
        if ($res !== false) {
            return true;
        } else {
            return false;
        }
    }

}
