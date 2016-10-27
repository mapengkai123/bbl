<?php

namespace core;

use \core\lib\route;

class imooc
{
	public static $classMap = array();
	protected $assign;
	public static function run()
	{
		\core\lib\log::init();
		session_start();
		$route = new route();
		$ControllerName = ucfirst($route->controller);
		$ActionName = $route->action;
		$ControllerFile = APP . '/controllers/' . $ControllerName . 'Controller.php';
		$ControllerClass = '\\' . MODULE .'\controller\\' . $ControllerName . 'Controller';
		if(is_file($ControllerFile)){
			include $ControllerFile;
			$controller = new $ControllerClass();
			$controller->$ActionName();
			\core\lib\log::log('Controller:'.$ControllerName.'       '.'Action:'.$ActionName);
		}else{
			throw new \Exception("找不到控制器".$ControllerName);	
		}
	}

	public static function load($class)
	{
		//自动加载类库
		// new \core\route();
		// $class = '\core\route';
		// IMOOC.'/core/route.php';
			
		if(isset($classMap[$class])) {
			return true;
		} else {
			$class = str_replace('\\', '/', $class);
			$file = IMOOC.'/'.$class.'.php';
			if(is_file($file)) {
				include $file;
				self::$classMap[$class] = $class;
			} else {
				return false;
			}
		}
	}

	public function assign($name,$value)
	{
		if(!isset($this->assign['host']))
		{
			$this->assign['host'] = route::$hosts;
		}
		$this->assign[$name] = $value;
	}

	public function display($file)
	{
		$views = $file;
		$file = APP . '/views/' . $file;
		if(is_file($file))
		{
			\Twig_Autoloader::register();
			$loader = new \Twig_Loader_Filesystem(APP."/views");
			$twig = new \Twig_Environment($loader, array(
				'cache' => IMOOC.'/log/twig',
				'debug'	=> DEBUG
			));
			$template = $twig->loadTemplate($views);
			$template->display($this->assign?$this->assign:array('host'=>route::$hosts));
		}
	}

}