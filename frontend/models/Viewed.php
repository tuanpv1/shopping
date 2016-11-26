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
            $n = count($viewed);
            $i = $n-1;
//            echo"<pre>";print_r($viewed);die();
            for($i ; $i >= 0; $i-- ){
                $viewed[$i+1] = $viewed[$i];
            }
            $viewed[0] = [
                'id'=>$arrayData['id'],
                'name'=> $arrayData['name'],
                'price'=> $arrayData['price'],
                'sale'=> $arrayData['sale'],
                'image'=> $arrayData['image'],
            ];
        }
        $session['viewed'] = $viewed;
    }
}