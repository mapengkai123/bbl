<?php
namespace core\lib;

use \core\lib\conf;
class log
{
    public static $class;
    /**
     * 1.确定日志储存方式
     * 2.写日志
     */
    public static function init()
    {
        //确定存储方式
        $drive = conf::get('DRIVE' ,'log');
        $class = '\core\lib\drive\log\\'.$drive;
        self::$class = new $class();
    }

    public static function log($name ,$file = 'log')
    {
        self::$class->log($name ,$file);
    }
}