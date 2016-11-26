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
                $n = count($viewed);
//                echo"<pre>";print_r($n);die();
                for($i = 1; $i <= $n; $i++){
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
        $session['viewed'] = $viewed;
    }
}