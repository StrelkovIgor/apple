<?php
/**
 * Created by PhpStorm.
 * User: crash
 * Date: 26.09.2019
 * Time: 20:18
 */

namespace backend\models;


class Apple
{
    protected $element = null;
    private $colorApple =[
        "green","Yellow", "Red"
    ];
    private $statusName = [
        "висит на дереве", "упало/лежит на земле", "гнилое яблоко"
    ];

    public function __construct($color = "")
    {
        if(in_array($color, $this->colorApple)){
            $element = $this->getElement(true);
            $element->color = $color;
            $element->saveAndUpdate();
        }
    }

    public function __set($name, $data){
        $this->getElement()->{$name} = $data;
    }

    public function __get($name){
        if($this->getElement())
            return $this->getElement()->{$name};
        //else throw new \Exception('Яблоко седино');
        else return null;
    }

    public function eat($eat = 1){
        if($this->status == 0) throw new \Exception("Яблоко на дереве");
        if($eat && !($this->status == 2 && (strtotime($this->date_drop) + $this->timer(5)) < time())){
            $this->size  = $this->size - ($eat / 100);
            if($this->size <=0){
                $this->delete();
            }else
            $this->getElement()->saveAndUpdate();
        }
    }

    private function getElement($new = false){
        $this->element = $new?new AppleTable():$this->element;
        return $this->element;
    }

    private function timer($int){
        return 60*60*$int;
    }

    public function delete(){
        $this->getElement()->delete();
        $this->element = null;
    }

    public function fallToGround(){
        $element = $this->getElement();
        if($element->status != 0) throw new \Exception("Яблоко не на дереве");
        $element->status = 1;
        $element->date_drop = date('Y-m-d H:i:s');
        $element->saveAndUpdate();
    }

    public function getStatus(){
        return $this->statusName[$this->status];
    }

    public function setRandom(){
        $this->getElement(true);
        $this->color = $this->colorApple[rand(0, count($this->colorApple) - 1)];
        $this->status =rand(0,2);
        if($this->status){
            if($this->status == 2)
                $time = rand(5, 10);
            else
                $time = rand(0, 4);
            $this->date_drop = date('Y-m-d H:i:s',time() - $this->timer($time));
        }
        $this->getElement()->saveAndUpdate();
    }

    public function setElement($element){
        $this->element = $element;
    }
    public function getData(){
        return [
            'id' => $this->id,
            'color' => $this->color,
            'size' => $this->size,
            'status' => $this->getStatus(),
            'drop' => $this->date_drop
        ];
    }

    public static function random(){
        AppleTable::deleteAll();
        $apples = [];
        $col = rand(1,15);
        for ($i = 0; $i<$col; $i++){
            $apples[$i] = new self();
            $apples[$i]->setRandom();
        }
        return $apples;
    }

    public static function getAll(){
        $el = AppleTable::find()->all();
        $data = [];
        foreach ($el as $key => $item){
           $data[$key] = new self();
           $data[$key]->setElement($item);
        }
        return $data;
    }

}