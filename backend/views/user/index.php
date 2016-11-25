<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $type */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý tài khoản';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span
                        class="caption-subject font-green-sharp bold uppercase">Quản lý tài khoản <?= User::getTypeNameByID($type) ?> </span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <?= Html::a('Thêm mới người dùng', ['create','type'=>$type], ['class' => 'btn btn-success']) ?>
            <div class="portlet-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                       // ['class' => 'yii\grid\SerialColumn'],

                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'image',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->image?Html::img('http://localhost/learnenglish/avatar/' .$model->image, ['width' => '200px']):Html::img('http://localhost/learnenglish/img/avt_df.png' , ['width' => '200px']);
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'username',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return Html::a($model->username, ['view', 'id' => $model->id], ['class' => 'label label-primary']);
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'fullname',
                            'width' => '50px',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->fullname;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'type',
                            'width' => '120px',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $widget) {
                                /**
                                 * @var $model \common\models\User
                                 */
                                if ($model->type == User::TYPE_ADMIN) {
                                    return '<span class="label label-danger">' . User::getTypeNameByID($model->type) . '</span>';
                                }
                                if($model->type == User::TYPE_USER){
                                    return '<span class="label label-success">' . User::getTypeNameByID($model->type) . '</span>';
                                }
                            },
                            'filter' => User::getListType(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => "Tất cả"],
                        ],
                        'email:email',

                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'status',
                            'width' => '120px',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $widget) {
                                /**
                                 * @var $model common\models\User
                                 */
                                if ($model->status == User::STATUS_ACTIVE) {
                                    return '<span class="label label-success">' . $model->getStatusName() . '</span>';
                                } else {
                                    return '<span class="label label-danger">' . $model->getStatusName() . '</span>';
                                }

                            },
                            'filter' => User::getListStatus(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => "Tất cả"],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}{delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['user/view', 'id' => $model->id]), [
                                        'title' => 'Thông tin user',
                                    ]);

                                },
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['user/update', 'id' => $model->id]), [
                                        'title' => 'Cập nhật thông tin user',
                                    ]);
                                },
                                'delete' => function ($url, $model) {
            //                        Nếu là chính nó thì không cho thay đổi trạng thái
                                    if ($model->id != Yii::$app->user->getId()) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['user/delete', 'id' => $model->id]), [
                                            'title' => 'Xóa user',
                                        ]);
                                    }
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
