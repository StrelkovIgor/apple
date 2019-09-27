<?php
/**
 * Created by PhpStorm.
 * User: crash
 * Date: 26.09.2019
 * Time: 19:59
 */
namespace backend\main\traitMain;

trait Overload
{
    protected $data = [];

    public function set($name, $value = null){
        if(is_array($name)){
            foreach ($name as $key => $value){
                $this->set($key, $value);
            }
        }else {
            $this->__set($name, $value);
        }
        return $this;
    }

    public function __set($name, $data){
        $this->data[$name] = $data;
    }

    public function __get($name){
        if(isset($this->data[$name])){
            return $this->data[$name]; // TODO: Implement __get() method.
        }
        return null;
    }

}