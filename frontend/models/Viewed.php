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
            $viewed[$id] = [
                'id'=>$arrayData['id'],
                'name'=> $arrayData['name'],
                'price'=> $arrayData['price'],
                'sale'=> $arrayData['sale'],
                'image'=> $arrayData['image'],
                'amount'=> 1,
            ];
        }else{
            $viewed = $session['viewed'];
            if(array_key_exists($id, $viewed)){
                $viewed[$id] = [
                    'id'=>$arrayData['id'],
                    'name'=> $arrayData['name'],
                    'price'=> $arrayData['price'],
                    'sale'=> $arrayData['sale'],
                    'image'=> $arrayData['image'],
                    'amount'=>$viewed[$id]['amount']+1,
                ];
            }else{
                $viewed[$id] = [
                    'id'=>$arrayData['id'],
                    'name'=> $arrayData['name'],
                    'price'=> $arrayData['price'],
                    'sale'=> $arrayData['sale'],
                    'image'=> $arrayData['image'],
                    'amount'=> 1,
                ];
            }
        }
        $session['viewed'] = $viewed;
    }
}