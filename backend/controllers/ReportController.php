<?php

namespace backend\controllers;

use backend\models\FormReport;
use common\models\Order;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class ReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionProduct()
    {
        $param = Yii::$app->request->queryParams;
        $from_date = isset($param['ReportDonationForm']['from_date']) ? $param['ReportDonationForm']['from_date'] : null;
        $to_date = isset($param['ReportDonationForm']['to_date']) ? $param['ReportDonationForm']['to_date'] : null;

        $report = new FormReport();
        $report->from_date = $from_date;
        $report->from_date = $to_date;
        $report->content = null;

        $report->generateReport();

        $report->dataProvider = new ActiveDataProvider([
            'query' => $report->content,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC
                ]
            ]
        ]);

//        echo "<pre>";print_r($report->content);die();
        return $this->render('report-product', [
            'report' => $report,
        ]);
    }
}
