<?php
namespace frontend\models;
use yii\base\Model;
use yii\web\Session;
use Yii;

class Cart
{
    public  function addCart($id,$arrayData){
        $session = Yii::$app->session;
        if(!isset($session['cart'])){
            $cart[$id] = [
                'id'=>$arrayData['id'],
                'name'=> $arrayData['name'],
                'price'=> $arrayData['price'],
                'sale'=> $arrayData['sale'],
                'image'=> $arrayData['image'],
                'amount'=> 1,
            ];
        }else{
            $cart = $session['cart'];
            if(array_key_exists($id, $cart)){
                $cart[$id] = [
                    'id'=>$arrayData['id'],
                    'name'=> $arrayData['name'],
                    'price'=> $arrayData['price'],
                    'sale'=> $arrayData['sale'],
                    'image'=> $arrayData['image'],
                    'amount'=>$cart[$id]['amount']+1,
                ];
            }else{
                $cart[$id] = [
                    'id'=>$arrayData['id'],
                    'name'=> $arrayData['name'],
                    'price'=> $arrayData['price'],
                    'sale'=> $arrayData['sale'],
                    'image'=> $arrayData['image'],
                    'amount'=> 1,
                ];
            }
        }
        $session['cart'] = $cart;
    }

    public function updateItem($id,$amount){
        $session = Yii::$app->session;
        $cart = $session['cart'];
        if(array_key_exists($id, $cart)){
            $cart[$id] = [
                'id'=>$cart[$id]['id'],
                'name'=> $cart[$id]['name'],
                'price'=> $cart[$id]['price'],
                'sale'=> $cart[$id]['sale'],
                'image'=> $cart[$id]['image'],
                'amount'=>$amount,
            ];
        }
        $session['cart'] = $cart;
    }

    public function deleteItem($id){
        $session = Yii::$app->session;
        if(isset($session['cart'])){
            $cart = $session['cart'];
            unset($cart[$id]);
            $session['cart'] = $cart;
        }
    }
}