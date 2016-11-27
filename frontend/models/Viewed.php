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
            $viewed[] = [
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
            $viewed1 = [
                'id'=>$arrayData['id'],
                'name'=> $arrayData['name'],
                'price'=> $arrayData['price'],
                'sale'=> $arrayData['sale'],
                'image'=> $arrayData['image'],
            ];
            array_unshift($viewed,$viewed1);
            $session['viewed'] = $viewed;
        }
//        echo"<pre>";print_r($viewed);die();
        $session['viewed'] = $viewed;
    }
}