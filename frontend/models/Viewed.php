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
                if($value['id']== $arrayData['id']){
                    unset($viewed[$key]);
                    $session['viewed'] = $viewed;
                }
            }
            $session['viewed'] = $viewed;
            if($session['viewed'] == null){
                $viewed[0] = [
                    'id'=>$arrayData['id'],
                    'name'=> $arrayData['name'],
                    'price'=> $arrayData['price'],
                    'sale'=> $arrayData['sale'],
                    'image'=> $arrayData['image'],
                ];
            }else{
//                echo"<pre>";print_r($viewed);die();
                if(!isset($viewed[0])){
                    $viewed[0] = [
                        'id'=>$arrayData['id'],
                        'name'=> $arrayData['name'],
                        'price'=> $arrayData['price'],
                        'sale'=> $arrayData['sale'],
                        'image'=> $arrayData['image'],
                    ];
                }else{
                    $n = count($viewed);
//                    echo"<pre>";print_r($n);die();
                    for($i = $n; $i >0; $i--){
                        $viewed[$i] = $viewed[$i-1];
                    }
                    $viewed[0] = [
                        'id'=>$arrayData['id'],
                        'name'=> $arrayData['name'],
                        'price'=> $arrayData['price'],
                        'sale'=> $arrayData['sale'],
                        'image'=> $arrayData['image'],
                    ];
                }
            }
        }
//        echo"<pre>";print_r($viewed);die();
        $session['viewed'] = $viewed;
    }
}