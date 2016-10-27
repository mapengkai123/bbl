<?php

namespace application\controller;


use core\lib\model;
use application\models\listsModel;
class OrderController extends \core\imooc
{
    //框架首页
    public function orderlist()
    {
        $this->display('order/order.php');
    }

    /**
     * 获取发单订单信息接口
     */
    public function getsend()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if($user_id==0){
            echo 1;die;
        }
        $model = new model();
        $fa_list = $model->select("send",[ "[>]user_info" => ["send.r_id" => "u_id"]],'*',['send.u_id'=>$user_id]);
        foreach ($fa_list as $k => $v) {
            $fa_list[$k]['s_time'] = date('Y-m-d' ,strtotime( $v['s_time']));
        }
        echo json_encode($fa_list);
    }


    /**
     * 获取接单订单信息接口
     */
    public function getget()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        if($user_id==0){
            echo 1;die;
        }
        $model = new model();
        $list = $model->select("send",[ "[>]user_info" => ["send.u_id" => "u_id"]],'*',['send.r_id'=>$user_id]);
        foreach($list as $k=>$v) {
            $list[$k]['s_time'] = date('Y-m-d' ,strtotime($v['s_time']));
        }
        echo json_encode($list);
    }

    /**
     * 页面
     */
    public function send_one()
    {
        $s_id = get('id');
        $this->assign('s_id',$s_id);
        $this->display('order/send_one.php');
    }

    /**
     * 发单详情
     */
    public function send_one_s()
    {
        $s_id = get('id');
        $u_id = $_SESSION['id'];
        $model = new model();
        $data = $model->get('send',["[>]user_info" => ["send.u_id" => "u_id"]],'*',['s_id'=>$s_id]);
        // print_r($model->error());die;
        echo json_encode($data);
    }

    /**
     * 判断发单人位置，算出距离
     */
    public function send_address()
    {
        $lng = get('lng');
        $lat = get('lat');
        $id  = get('id');
        $lists = new listsModel();
        $data = $lists->distance_address($id);
        //将角度转为弧度
        $radLat1=deg2rad($data['s_f_lat']);//deg2rad()函数将角度转换为弧度
        $radLat2=deg2rad($lat);
        $radLng1=deg2rad($data['s_f_lng']);
        $radLng2=deg2rad($lng);
        $a=$radLat1-$radLat2;
        $b=$radLng1-$radLng2;
        $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
        $distance = substr($s,0,strpos($s,'.'));
        // echo $distance;die;
        // echo $distance;die;
        if($distance>1500)
        {
            echo '1';die;
        }else{
            //id，开发完成之后需要修改
            $s_id = $_SESSION['id'];
            //接单人恢复违约金额
            $lists = new listsModel();
            $bool = $lists->send_money($id,$s_id);
            if($bool)
            {
                echo '0';
            }else{
                echo '1';
            }
        }
    }

}
