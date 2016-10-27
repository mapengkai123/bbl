<?php

namespace application\controller;

class CommonController extends \core\imooc
{
	/**
	 * 公共控制器
	 * @2016-10-21
	 * @mpk
	 */
	public function checklog()
	{
        echo  isset($_SESSION['id']) ? $_SESSION['id'] : 0 ;
    }
}
