<?php
namespace application\models;

use core\lib\model;

class listsModel extends model
{
    private $table = 'send';
    private $table1= 'user_info';

    //订单入库
    public function add_lists($data,$u_id)
    {
        $user = $this->get($this->table1,'balance',['u_id'=>$u_id]);
        if($user>=$data['s_list_money']+$data['s_violate_money'])
        {
            $bool1 = $this->insert($this->table,$data);
            $bool2 = $this->update($this->table1,['balance[-]'=>$data['s_list_money']+$data['s_violate_money']],['u_id'=>$u_id]);
            if($bool1 && $bool2)
            {
                return true;
            }
        }else{
            return false;
        }
    }

    //订单列表
    public function lists($u_id)
    {
    	return $this->select($this->table,["[><]user"=>["u_id"=>"u_id"]],['s_id','send.u_id','s_time','s_m_lng','s_m_lat','s_violate_money','s_title','u_name','star_num'],["AND"=>["send.u_id[!]"=>$u_id,"s_type"=>1]]);
    }

    //发单订单详情
    public function receive_details($id)
    {
        return $data = $this->get($this->table,["[><]user"=>["u_id"=>"u_id"]],'*',array('s_id'=>$id));
        // print_r($data);die;
    }

    //接单
    public function receive_one($id,$r_id,$v_money)
    {
        $money = $this->get($this->table1,'balance',array('u_id'=>$r_id));
        //判断接单人的金额是否大于等于违约金的金额
        if($money>=$v_money)
        {
            //扣除接单人违约金
            $this->update($this->table1,array('balance[-]'=>$v_money),array('u_id'=>$r_id));
            //接收订单
            $this->update($this->table,array('r_id'=>$r_id),array('s_id'=>$id));
            //改变订单状态为已接收订单
            $this->update($this->table,['s_type'=>2],['s_id'=>$id]);
            return true;
        }else{
            return false;
        }
    }

    //任务距离
    public function distance_address($id)
    {
        return $this->get($this->table,['s_m_lng','s_m_lat','s_f_lng','s_f_lat'],['s_id'=>$id]);
    }

    //接单人恢复违约金额
    public function receive_money($id,$r_id)
    {
        //本单违约金额
        $v_money = $this->get($this->table,['s_violate_money'],['s_id'=>$id]);
        $v_money = $v_money['s_violate_money'];
        //金额恢复
        $bool1 = $this->update($this->table1,array('balance[+]'=>$v_money),array('u_id'=>$r_id));
        //订单状态改变为已到达任务地点
        $bool2 = $this->update($this->table,['s_type'=>3],['s_id'=>$id]);
        //违约状态改变
        $bool3 = $this->update($this->table,['s_violate_r'=>1],['s_id'=>$id]);
        if($bool1 && $bool2 && $bool3)
        {
            return true;
        }else{
            return false;
        }
    }

    //发单人恢复违约金额
    public function send_money($id,$s_id)
    {
        //本单违约金额
        $v_money = $this->get($this->table,['s_violate_money'],['s_id'=>$id]);
        $v_money = $v_money['s_violate_money'];
        //金额恢复
        $bool1 = $this->update($this->table1,array('balance[+]'=>$v_money),array('u_id'=>$s_id));
        //订单状态改变为已到达任务地点
        // $bool2 = $this->update($this->table,['s_type'=>3],['s_id'=>$id]);
        //违约状态改变
        $bool2 = $this->update($this->table,['s_violate_u'=>1],['s_id'=>$id]);
        if($bool1 && $bool2)
        {
            return true;
        }else{
            return false;
        }
    }

    //判断订单完成密码是否正确
    public function check_pwd($s_id,$pwd,$u_id)
    {
        $pwd1 = $this->get($this->table,'s_pwd',['s_id'=>$s_id]);
        // echo $pwd1.'---'.md5($pwd);die;
        if($pwd1!=$pwd)
        {
            return false;
        }else{
            $bool1 = $this->update($this->table,['s_type'=>4],['s_id'=>$s_id]);
            //增加信誉度
            $data = $this->get($this->table,['u_id','r_id'],['s_id'=>$s_id]);
            $bool2 = $this->update($this->table1,['buy_credit[+]' => 5],['u_id' => $u_id]);
            $bool3 = $this->update($this->table1,['sell_credit[+]' => 5],['u_id' => $u_id]);
            if($bool1 && $bool2 && $bool3)
            {
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * 判断订单是否已经被接收
     */
    public function if_receive($s_id)
    {
        $data = $this->get($this->table1,['r_id'],['s_id' => $s_id]);
        return $data['r_id'];
    }


}