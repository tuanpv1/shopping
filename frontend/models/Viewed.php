<?php
namespace frontend\models;
use yii\base\Model;
use yii\web\Session;
use Yii;

class Viewed
{
    public  function addViewed($id,$arrayData){
        $session = Yii::$app->session;
        if(!isset($session['viewed'])){
            $viewed[0] = [
                'id'=>$arrayData['id'],
                'name'=> $arrayData['name'],
                'price'=> $arrayData['price'],
                'sale'=> $arrayData['sale'],
                'image'=> $arrayData['image'],
            ];
        }else{
            $viewed = $session['viewed'];
            foreach($viewed as $key => $value) {
//                echo"<pre>";print($arrayData['id'].$value['id']);die();
                if($value['id']== $arrayData['id'] && $key == 0){
                    $viewed[0] = [
                        'id'=>$arrayData['id'],
                        'name'=> $arrayData['name'],
                        'price'=> $arrayData['price'],
                        'sale'=> $arrayData['sale'],
                        'image'=> $arrayData['image'],
                    ];
                }elseif($value['id']== $arrayData['id']){
                    unset($viewed[$key]);
                    $session['viewed'] = $viewed;
                }
            }
            $session['viewed'] = $viewed;
            $n = count($viewed);
            $i = $n;
//            echo"<pre>";print_r($viewed);die();
            for($i=0 ; $i < $n; $i++ ){
                $viewed[$i+1] = $viewed[$i];
                if($viewed[$i]['id'] != $arrayData['id']){
                    $viewed[$i] = [
                        'id'=>$arrayData['id'],
                        'name'=> $arrayData['name'],
                        'price'=> $arrayData['price'],
                        'sale'=> $arrayData['sale'],
                        'image'=> $arrayData['image'],
                    ];
                }else{
                    unset($viewed[$i]);
                }
            }
        }
        $session['viewed'] = $viewed;
    }
}