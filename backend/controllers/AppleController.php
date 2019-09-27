<?php
/**
 * Created by PhpStorm.
 * User: crash
 * Date: 26.09.2019
 * Time: 17:43
 */

namespace backend\controllers;

use Yii;
use backend\main\Controller;
use backend\models\Apple;

class AppleController extends Controller
{
    public function actionIndex(){

        $this->html->element = Apple::getAll();

        return $this->view('index');
    }

    public function actionAjax(){
        $request = Yii::$app->request;

        $post = $request->post();

        switch ($post['req']){
            case 'gen':
                    $el = Apple::random();
                    $data = [];
                    foreach ($el as $item){
                        $data[] = $item->getData();
                    }
                    $this->html->set($data);
                break;
            case 'eat':
            case 'drop':
                    $el = Apple::getAll();
                    $data = [];
                    foreach ($el as $item){
                        try{
                            if($item->id == $post['id'])
                                if($post['req'] == 'eat')
                                    $item->eat((int) $post['val']);
                                else
                                    $item->fallToGround();
                        }catch (\Exception $e){
                            $this->html->error = $e->getMessage();
                        }
                        try{
                            $data[] = $item->getData();
                        }catch (\Exception $e){

                        }
                    }
                    $this->html->set(['items' => $data]);
                break;
            default:
                return json_encode(['success' => false,'message' => "Запрос не найден"],256);
        }
        return json_encode(array_merge(['success' => true], ['data' => $this->html->getData()]),256);
    }

}