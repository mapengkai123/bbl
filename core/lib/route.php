<?php

namespace core\lib;
use core\lib\conf;

class route
{
	public $controller;
	public $action;
	public static $hosts;
	
	public function __construct()
	{
		// xxx.com/index/index
		/**
		 * 1.隐藏index.php
		 * 2.获取url 参数部分
		 * 3.返回对应的控制器和方法
		 */
		
		$document_root = $_SERVER['DOCUMENT_ROOT'];
		$script_filename = $_SERVER['SCRIPT_FILENAME'];
		$host = 'http://'.$_SERVER['HTTP_HOST'].str_replace('index.php','',str_replace($document_root,'',$script_filename));
		self::$hosts = $host;
		$http = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$request = str_replace($host,'/',$http);
		if(strstr($request,'?')) {
				$request = str_replace(strstr($request,'?'),'',$request);
			}
		if($request != '/') {
			$path = $request;
			$patharr = explode('/', trim($path, '/'));
			if(isset($patharr[0])){
				$this->controller = $patharr[0];
				unset($patharr[0]);
			}
			if(isset($patharr[1])){
				$this->action = $patharr[1];
				unset($patharr[1]);
			}else{
				$this->action = conf::get('DEFAULT_ACTION','route');
			}

			//url多余部分转化为GET参数
			//a/1/b/2/c/3
			$count = count($patharr) + 2;
			$i = 2;
			while ($i < $count) {
				if(isset($patharr[$i + 1])) {
					$_GET[$patharr[$i]] = $patharr[$i + 1];
				}
				$i += 2 ;
			}
		} else {
			$this->controller = conf::get('DEFAULT_CONTROLLER','route');
			$this->action = conf::get('DEFAULT_ACTION','route');
		}
	}
}