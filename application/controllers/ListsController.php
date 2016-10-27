<?php

namespace application\controller;

use application\models\listsModel;

class ListsController extends \core\imooc
{
	//发单首页
	public function send()
	{
		$this->display('lists/send.php');
	}

	//发单信息添加入库
	public function add_lists()
	{
		$u_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0 ;
		if($u_id==0)
		{
			jump('login/login');die;
		}
		$little='';
		for($i=0;$i<2;$i++)
		{
			$little=$little.chr(rand(97,122));
		}
		//生成订单随机密码
		$pwd = $little.rand(1000,9999);
		//经纬度拆分
		$s_mission = explode(',',post('mission'));
		$s_finish  = explode(',',post('finish'));
		// $u_id = 	$_SESSION['id'];
		$data['u_id'] = $u_id;
		$data['s_title'] = 		post('title');
		$data['s_content'] = 	post('content');
		$data['s_call'] = 		post('call');
		$data['s_time'] =		date('Y-m-d H:i:s');
		$data['s_end_time'] = 	post('end_time');
		$data['s_list_money']=	post('list_money');
		$data['s_violate_money']=post('violate_money');
		$data['s_address'] = 	post('address');
		$data['s_s_address'] =	post('s_address');
		$data['s_end_address']=	post('end_address');
		$data['s_s_end_address']=	post('s_end_address');
		$data['s_m_lng'] =		$s_mission[0];
		$data['s_m_lat'] =		$s_mission[1];
		$data['s_f_lng'] =		$s_finish[0];
		$data['s_f_lat'] =		$s_finish[1];
		$data['s_pwd'] =		$pwd;
		$lists = new listsModel();
		$bool = $lists->add_lists($data,$u_id);
		if($bool)
		{
			//发布之后跳到订单列表页
			jump('order/orderlist');
		}else{
			//余额不足条充值页
			echo "<script>alert('余额不足，请充值');</script>";
			$this->display('lists/send.php');
			// jump('property/recharge');
		}
	}

	//接单首页
	public function receive()
	{
		$this->display('lists/receive.php');	
	}

	//带距离首页列表
	public function receive_list()
	{
		$array = array();
		$distance = get('distance');
		$lng2 = get('lng');
		$lat2 = get('lat');
		$lists = new listsModel();
		//开发完成后需要更改
		$u_id = $_SESSION['id'];
		$data = $lists->lists($u_id);
		foreach($data as $key=>$val)
		{
			//将角度转为弧度
			$radLat1=deg2rad($val['s_m_lat']);//deg2rad()函数将角度转换为弧度
			$radLat2=deg2rad($lat2);
			$radLng1=deg2rad($val['s_m_lng']);
			$radLng2=deg2rad($lng2);
			$a=$radLat1-$radLat2;
			$b=$radLng1-$radLng2;
			$s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
			$data[$key]['distance'] = substr($s,0,strpos($s,'.'));
		}
		// echo json_encode($data);die;
		foreach($data as $key=>$val)
		{
			if($val['distance']<=$distance)
			{
				$array[] = $val;
			}
		}
		// print_r($array);
		echo json_encode($array);
	}

	//接单详情
	public function receive_one()
	{
		$this->assign('money',get('money'));
		$this->assign('id',get('id'));
		$this->display('lists/receive_one.php');
	}

	//未接订单页详情
	public function receive_details()
	{
		$id = get('id');
		$lists = new listsModel();
		$data = $lists->receive_details($id);
		echo json_encode($data);
	}

	//接单
	public function receive_lists()
	{
		$r_id = $_SESSION['id'];
		$id=get('id');
		$v_money = get('money');
		$lists = new listsModel();
		$bool = $lists->receive_one($id,$r_id,$v_money);
		if($bool)
		{
			echo '1';
		}else{
			echo '0';
		}
	}

	//订单首页
	public function lists()
	{
		$this->assign('money',get('money'));
		$this->assign('id',get('id'));
		$this->display('lists/list_one.php');
	}

	//判断距离是否到达任务地点
	public function address()
	{
		$lng = get('lng');
		$lat = get('lat');
		$id  = get('id');
		$lists = new listsModel();
		$data = $lists->distance_address($id);
		//将角度转为弧度
		$radLat1=deg2rad($data['s_m_lat']);//deg2rad()函数将角度转换为弧度
		$radLat2=deg2rad($lat);
		$radLng1=deg2rad($data['s_m_lng']);
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
			$r_id = $_SESSION['id'];
			//接单人恢复违约金额
			$lists = new listsModel();
			$bool = $lists->receive_money($id,$r_id);
			if($bool)
			{
				echo '0';
			}else{
				echo '1';
			}
		}
	}

	//完成订单确认密码
	public function finish()
	{
		$s_id = get('s_id');
		$u_id = $_SESSION['id'];
		$pwd  = get('pwd');
		$lists = new listsModel();
		$bool = $lists->check_pwd($s_id,$pwd,$u_id);
		if($bool)
		{
			echo '1';
		}else{
			echo '0';
		}
	}

	/**
	 * 订单是否已经被接收
	 */
	public function if_receive()
	{
		$s_id = get('s_id');
		$lists = new listsModel();
		$data = $lists->if_receive($s_id);
		echo json_encode($data);die;
	}
}