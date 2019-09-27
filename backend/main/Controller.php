<?php
/**
 * Created by PhpStorm.
 * User: crash
 * Date: 26.09.2019
 * Time: 16:24
 */

namespace backend\main;

use Yii;
use yii\web\Controller as YiiController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class Controller extends YiiController
{
    private $actionMain = [];
    protected $html  = null;

    public function __construct($id, $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        //Устанавливаем все экшены на проверку админа
        $this->setActionMain();
        //Будем передавать вьюшкам не массив а объект
        $this->html = new Html();
    }

    private function setActionMain(){;
        $this->actionMain = array_filter(array_map(function($e){
            preg_match('/action([A-Z][a-z0-9]+)/',$e,$math);
            return isset($math[1])?mb_strtolower($math[1]):null;
        }, get_class_methods(static::className())));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => $this->actionMain,
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (bool) Yii::$app->user->identity->is_admin;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    protected function view($name){
        return $this->render($name, $this->html->view());
    }

}