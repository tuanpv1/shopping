<?php
use  common\models\Product;
    $totalAmount = 0;
    $total=0;
    if(isset($cartInfo)){
        foreach($cartInfo as $key => $value){
            $totalAmount += $value['amount'];
//            if($value['sale'] == 0) {
//                $total += $value['price'] * $value['amount'];
//            }else {
//                $sal = ($value['price']*(100-$value['sale']))/100;
//                $total += $sal * $value['amount'];
//            }
        }
    }
?>
<li>
    <a href="<?= \yii\helpers\Url::to(['shopping-cart/list-my-cart'])?>">
        <i class="fa fa-shopping-cart"></i>
        <span id = "amount" style="color:#FE980F;"><?= $totalAmount ?></span> Sản phẩm
    </a>
</li>