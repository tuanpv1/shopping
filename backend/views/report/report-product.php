<?php

use common\helpers\CommonUtils;
use common\models\Campaign;
use common\models\Product;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $report \backend\models\ReportDonationForm */
/* @var $subscriber_provider_id int */
/* @var $this yii\web\View */

$this->title = 'Thống kê';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">

                <div class="report-user-daily-index">

                    <div class="row form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <?php $form = ActiveForm::begin([
                                'action' => Url::to(['report/donation']),
                                'method' => 'GET'
                            ]); ?>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?= $form->field($report, 'from_date')->widget(\kartik\widgets\DatePicker::classname(), [
                                                'options' => ['placeholder' => 'Ngày bắt đầu'],
                                                'type' => \kartik\widgets\DatePicker::TYPE_INPUT,
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => 'dd/mm/yyyy'
                                                ]
                                            ]); ?>

                                        </div>
                                        <div class="col-md-6">
                                            <?= $form->field($report, 'to_date')->widget(\kartik\widgets\DatePicker::classname(), [
                                                'options' => ['placeholder' => 'Ngày kết thúc'],
                                                'type' => \kartik\widgets\DatePicker::TYPE_INPUT,
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => 'dd/mm/yyyy'
                                                ]
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= \yii\helpers\Html::submitButton('Thống kê', ['class' => 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

                    <?php if ($report->dataProvider) { ?>
                        <?= GridView::widget([
                            'dataProvider' => $report->dataProvider,
                            'responsive' => true,
                            'pjax' => true,
                            'hover' => true,
                            'showPageSummary' => true,
                            'columns' => [
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'attribute' => 'date',
                                    'label' => 'Ngày',
                                    'width' => '150px',
                                    'value' => function ($model) {
                                        return date('d/m/Y', strtotime($model->date));
                                    },
                                    'pageSummary' => "Tổng số"
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Tổng số lượng SP',
                                    'value' => function ($model) {
                                        return $model->number;
                                    },
                                    'pageSummary' => $report->content->sum('number') ? $report->content->sum('number')  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Doanh thu',
                                    'value' => function ($model) {
                                        return $model->total?Product::formatNumber($model->total).' VND':0;
                                    },
                                    'pageSummary' => $report->content->sum('total') ?Product::formatNumber($report->content->sum('total')).' VND'  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Số lượng SP vừa đặt',
                                    'value' => function ($model) {
                                        return $model->number_ordered?$model->number_ordered:0;
                                    },
                                    'pageSummary' => $report->content->sum('number_ordered') ? $report->content->sum('number_ordered')  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Doanh thu vừa đặt',
                                    'value' => function ($model) {
                                        return $model->total_ordered?Product::formatNumber($model->total_ordered).' VND':0;
                                    },
                                    'pageSummary' => $report->content->sum('total_ordered') ?Product::formatNumber( $report->content->sum('total_ordered')).' VND'  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Số lượng SP đã thu tiền',
                                    'value' => function ($model) {
                                        return $model->number_success?$model->number_success:0;
                                    },
                                    'pageSummary' => $report->content->sum('number_success') ? $report->content->sum('number_success')  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Doanh thu đã tiền',
                                    'value' => function ($model) {
                                        return $model->total_success?Product::formatNumber($model->total_success).' VND':0;
                                    },
                                    'pageSummary' => $report->content->sum('total_success') ? Product::formatNumber($report->content->sum('total_success')).' VND'  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Số lượng SP đang chuyển đi',
                                    'value' => function ($model) {
                                        return $model->number_tranport?$model->number_tranport:0;
                                    },
                                    'pageSummary' => $report->content->sum('number_tranport') ? $report->content->sum('number_tranport')  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Doanh thu đang chuyển đi',
                                    'value' => function ($model) {
                                        return $model->total_tranport?Product::formatNumber($model->total_tranport).' VND':0;
                                    },
                                    'pageSummary' => $report->content->sum('total_tranport') ? Product::formatNumber($report->content->sum('total_tranport')).' VND'  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Số lượng SP bị hoàn trả',
                                    'value' => function ($model) {
                                        return $model->number_return?$model->number_return: 0;
                                    },
                                    'pageSummary' => $report->content->sum('number_return') ? $report->content->sum('number_return')  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Doanh thu bị hoàn trả',
                                    'value' => function ($model) {
                                        return $model->total_return?Product::formatNumber($model->total_return).' VND':0;
                                    },
                                    'pageSummary' => $report->content->sum('total_return') ? Product::formatNumber($report->content->sum('total_return')).' VND'  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Số lượng SP thất lạc',
                                    'value' => function ($model) {
                                        return $model->number_error?$model->number_error: 0;
                                    },
                                    'pageSummary' => $report->content->sum('number_error') ? $report->content->sum('number_error')  : 0
                                ],
                                [
                                    'class' => '\kartik\grid\DataColumn',
                                    'label' => 'Doanh thu thất lạc',
                                    'value' => function ($model) {
                                        return $model->total_error?Product::formatNumber($model->total_error).' VND':0;
                                    },
                                    'pageSummary' => $report->content->sum('total_error') ? Product::formatNumber($report->content->sum('total_error')).' VND': 0
                                ],
                            ],
                            'panel' => [
                                'type' => GridView::TYPE_ACTIVE,
                            ],
                            'toolbar' => [

                                '{export}',
                            ],
                            'export' => [
                                'fontAwesome' => true,
                                'showConfirmAlert' => false,
                                'target' => GridView::TARGET_BLANK,

                            ],
                            'exportConfig' => [
                                GridView::EXCEL => ['label' => 'Excel'],
                            ],

                        ]); ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>