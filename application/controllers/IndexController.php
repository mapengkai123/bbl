<?php

namespace application\controller;

use application\models\userModel;
class IndexController extends \core\imooc
{
	//框架首页
	public function index()
	{
		$this->display('index/index.html');
	}
    //个人中心
    public function self(){
        $id=isset($_SESSION['id'])?$_SESSION['id']:0;
        if($id==0){
            jump('Login/login');
        }else{
            $model=new userModel();
            //已发单
            $fa=$model->counts('send',['u_id'=>$id]);
            //接单
            $jie=$model->counts('send',['u_id'=>$id]);
            $res=$model->getone('user_info',['u_id'=>$id]);
            $result['name']=$res['nickname'];
            $result['balance']=$res['balance'];
            $result['time']=$res['lastlogintime'];
            $result['fa']=$fa;
            $result['jie']=$jie;
            $this->assign("one",$result);
            $this->display('self.php');
        }
    }
}