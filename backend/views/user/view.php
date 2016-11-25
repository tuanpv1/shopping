<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Xem thông tin người dùng '.$model->fullname?$model->fullname:$model->username;
$this->params['breadcrumbs'][] = ['label' => 'QL người dùng '.User::getTypeNameByID($model->type), 'url' => ['index','type'=>$model->type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"><?= $this->title ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-custom ">
                    <p>
                        <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Xóa', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Bạn chắc chắn muốn xóa người dùng này?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                        'attributes' => [
                            [
                                'label' => 'Ảnh đại diện',
                                'format' => 'html',
                                'value' => $model->image?Html::img('http://localhost/learnenglish/avatar/' .$model->image, ['width' => '200px']):Html::img('http://localhost/learnenglish/img/avt_df.png' , ['width' => '200px']),
                            ],
                            ['attribute' => 'username', 'format' => 'raw', 'value' => '<kbd>' . $model->username . '</kbd>', 'displayOnly' => true],
                            [
                                'label' => 'Họ tên',
                                'format' => 'html',
                                'value' => $model->fullname,
                            ],
                            'email:email',
                            'phone',
                            'address',
                //                        'role',
                            [
                                'attribute' => 'status',
                                'label' => 'Trạng thái',
                                'format' => 'raw',
                                'value' => ($model->status == User::STATUS_ACTIVE) ?
                                    '<span class="label label-success">' . $model->getStatusName() . '</span>' :
                                    '<span class="label label-danger">' . $model->getStatusName() . '</span>',
                                'type' => DetailView::INPUT_SWITCH,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'onText' => 'Active',
                                        'offText' => 'Delete',
                                    ]
                                ]
                            ],
                            [
                                'attribute' => 'type',
                                'format' => 'raw',
                                'value' => ($model->type == User::TYPE_ADMIN) ?
                                    '<span class="label label-success">' . $model->getTypeName() . '</span>' :
                                    '<span class="label label-danger">' . $model->getTypeName() . '</span>',
                                'type' => DetailView::INPUT_SWITCH,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'onText' => 'Active',
                                        'offText' => 'Delete',
                                    ]
                                ]
                            ],
                            [                      // the owner name of the model
                                'attribute' => 'created_at',
                                'label' => 'Ngày tham gia',
                                'value' => date('d/m/Y H:i:s', $model->created_at),
                            ],
                            [                      // the owner name of the model
                                'attribute' => 'updated_at',
                                'label' => 'Ngày thay đổi thông tin',
                                'value' => date('d/m/Y H:i:s', $model->updated_at),
                            ],

                //                        'type',
                //                        'service_provider_id',
                //                        'content_provider_id',
                //                        'parent_id',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>