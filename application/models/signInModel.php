<?php
namespace application\models;

use core\lib\model;

class signInModel extends model
{
    private $table = 'user_info';
    private $table1= 'sign_in';
    private $table2= 'goods';
    private $table3= 'user_goods';

    /**
     * 签到
     * 查看是否已签到
     */
    public function add($u_id)
    {
        $u_date = $this->get($this->table,['u_date','sum_num','month_num'],['u_id'=>$u_id]);
        $l_date = $this->get($this->table1,'*',['u_id' => $u_id,'ORDER' => [$this->table1.'.s_date' => 'DESC']]);
        // print_r($l_date);die;
        // print_r($u_date);die;
        if(strtotime($u_date['u_date'])!=strtotime(date('Y-m-d')))
        {
            //如果未签到，则在库中签到并把签到日期更新为当天
            $this->update($this->table,['u_date' => date('Y-m-d')],['u_id' => $u_id]);
            if(strtotime($l_date['s_date'])!=strtotime(date('Y-m-d',strtotime('-1 days'))))
            {
                $bool = $this->insert($this->table1,['u_id' => $u_id,'l_num' => 1,'s_date' => date('Y-m-d')]);
                $this->update($this->table,['sum_num' => $u_date['sum_num']+1],['u_id' => $u_id]);
                $this->update($this->table,['integral' => $u_date['integral']+1],['u_id' => $u_id]);
                return ['day' => 1];
            }else{
                $bool = $this->insert($this->table1,['u_id' => $u_id,'l_num' => $l_date['l_num']+1,'s_date' => date('Y-m-d')]);
                $this->update($this->table,['sum_num' => $u_date['sum_num']+1],['u_id' => $u_id]);
                $this->update($this->table,['integral' => $u_date['integral']+1],['u_id' => $u_id]);
                return ['day' => $l_date['l_num']+1];
            }
        }else{
            return 0;
        }
    }

    /**
     * 连续签到次数&&签到次数
     */
    public function num($u_id)
    {
        //总签到次数
        $sum = $this->get($this->table,['sum_num','integral'],['u_id' => $u_id]);
        //连续签到
        $data = $this->get($this->table1,'*',['u_id' => $u_id,'ORDER' => [$this->table1.'.s_date' => 'DESC']]);
        if($data['s_date']!=date('Y-m-d'))
        {
            if(strtotime($data['s_date'])!=strtotime(date('Y-m-d',strtotime('-1 days'))))
            {
                return 0;
            }else{
                return ['day' => $data['l_num'],'sum' => $sum['sum_num'],'integral' => $sum['integral']];
            }
        }else{
            return ['day' => $data['l_num'],'sum' => $sum['sum_num'],'integral' => $sum['integral']];
        }
    }

    /**
     * 商品兑换
     */
    public function exchange($id,$u_id)
    {
        $user_info = $this->get($this->table,['integral'],['u_id' => $u_id]);
        $goods_info = $this->get($this->table2,['g_click'],['g_id' => $id]);
        if($goods_info)
        {
            if($user_info['integral']>=$goods_info['g_click'])
            {
                $user_goods = $this->get($this->table3,'*',["AND" => ['u_id' => $u_id,'g_id' => $id]]);
                //查看是否已兑换过此商品
                if($user_goods)
                {
                    //如果已经兑换则修改数量
                    $this->update($this->table3,['u_num' => $user_goods['u_num']+1],['u_id' => $u_id]);
                    $this->update($this->table,['integral' => $user_info['integral']-$goods_info['g_click']],['u_id' => $u_id]);
                    return 2;
                }else{
                    //如果未兑换过则添加一条
                    $this->insert($this->table3,['g_id' => $id,'u_id' => $u_id,'u_num' => 1]);
                    $this->update($this->table,['integral' => $user_info['integral']-$goods_info['g_click']],['u_id' => $u_id]);
                    return 2;
                }
            }else{
                return 0;
            }
        }else{
            return 1;
        }
        
    }

    /**
     * 个人奖品列表
     */
    public function price_list($u_id)
    {
        $data = $this->select($this->table3,["[><]goods"=>["g_id"=>"g_id"]],'*');
        if($data)
        {
            return $data;
        }else{
            return 0;
        }
    }

}
