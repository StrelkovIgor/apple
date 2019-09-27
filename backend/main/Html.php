<?php
/**
 * Created by PhpStorm.
 * User: crash
 * Date: 26.09.2019
 * Time: 18:05
 */

namespace backend\main;

use backend\main\traitMain\Overload;

class Html
{
    use Overload;
    protected $data = [];
    protected $form = [];

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

    public function view(){
        return ['html' => $this];
    }

    public function getData(){
        return $this->data;
    }

}