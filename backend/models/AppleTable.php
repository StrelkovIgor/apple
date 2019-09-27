<?php
/**
 * Created by PhpStorm.
 * User: crash
 * Date: 26.09.2019
 * Time: 19:06
 */
namespace backend\models;

use yii\db\ActiveRecord;

class AppleTable extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%apple}}';
    }

    public function saveAndUpdate(){
        $this->save();
        $el = self::find()->where(['id' => $this->getPrimaryKey()])->all();
        $this->setVarible($el[0]);
    }

    public function setVarible($el){
        foreach ($el->toArray() as $key => $value) $this->{$key} = $value;
    }



}