<?php
namespace application\models;

use core\lib\model;

class userModel extends model
{
    /*
  * 查询所有数据
  */
    public function sel($table,$where="*"){
        $select= $this->select($table,$where);
        return $select;
    }
    /*
     * 添加
     */
    public function add($table,$arr){
        $add=$this->insert($table,$arr);
        return $add;
    }
    /*
     * 删除
     */
    public function del($table,$where){
        $del=$this->delete($table,$where);
        return $del;
    }
    /*
     * where多条件
     */
    public function where($table,$arr){
        $select= $this->select($table,"*",["AND" =>$arr]);
        //var_dump($select);die;
        return $select;
    }
    /*
     * where单挑件
     */
    public function getone($table,$arr){
        $one=$this->get($table,'*',$arr);
        //var_dump($one);die;
        return $one;
    }

    /*
     * 单条个数
     */
    public function counts($table,$where){
        $one=$this->count($table, $where);
//        var_dump($this->error());die;
        return $one;
    }

    /*
     * 多表多条件
     */
    public function joins($table,$join,$columns='*',$where){
        $many=$this->select($table, $join, $columns,$where);
//        var_dump($many);die;
        return $many;
    }
    /*
     * 修改
     */
    public function save($table, $data, $where){
        $save=$this->update($table, $data, $where);
        return $save;
    }

}