<?php

/**
 * Swiss army knife to work with user and rbac in command line
 * @author: Nguyen Chi Thuc
 * @email: gthuc.nguyen@gmail.com
 */
namespace console\controllers;

use common\models\Order;
use common\models\OrderDetail;
use common\models\Report;
use common\models\User;
use DateTime;
use Exception;
use Yii;
use yii\console\Controller;

/**
 * UserController create user in commandline
 */
class ReportController extends Controller
{
    public function actionReportDonation($start_day = '')
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            print("Bat dau chay bao cao \n");

            if ($start_day != '') {
                $to_day = strtotime(DateTime::createFromFormat("dmY", $start_day)->setTime(0, 0)->format('Y-m-d H:i:s'));
                $end_day = strtotime(DateTime::createFromFormat("dmY", $start_day)->setTime(23, 59, 59)->format('Y-m-d H:i:s'));
                $to_day_date = DateTime::createFromFormat("dmY", $start_day)->setTime(0, 0)->format('Y-m-d H:i:s');
            } else {
                $to_day = strtotime("midnight", time());
                $end_day = strtotime("tomorrow", $to_day) - 1;
                $to_day_date = (new DateTime('now'))->setTime(0, 0)->format('Y-m-d H:i:s');
            }

            print("Thoi gian bat dau: $to_day : Thoi gian ket thuc: $end_day ");
            print("Convert sang ngay: $to_day_date \n");
            // xoa cot neu da chay truoc do de tranh sinh nhieu truong
            Yii::$app->db->createCommand()->delete('report', ['date' => $to_day_date])->execute();
            // tinh tong san pham
            $number = OrderDetail::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->sum('number');
            $number_success = OrderDetail::find()
                ->innerJoin('order','order.id = order_detail.order_id')
                ->andWhere('order_detail.created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('order_detail.created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['order.status'=>Order::STATUS_SUCCESS])
                ->sum('number');
            $number_error = OrderDetail::find()
                ->innerJoin('order','order.id = order_detail.order_id')
                ->andWhere('order_detail.created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('order_detail.created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['order.status'=>Order::STATUS_ERROR])
                ->sum('number');
            $number_tran = OrderDetail::find()
                ->innerJoin('order','order.id = order_detail.order_id')
                ->andWhere('order_detail.created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('order_detail.created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['order.status'=>Order::STATUS_TRANSPORT])
                ->sum('number');
            $number_order = OrderDetail::find()
                ->innerJoin('order','order.id = order_detail.order_id')
                ->andWhere('order_detail.created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('order_detail.created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['order.status'=>Order::STATUS_ORDERED])
                ->sum('number');
            $number_return = OrderDetail::find()
                ->innerJoin('order','order.id = order_detail.order_id')
                ->andWhere('order_detail.created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('order_detail.created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['order.status'=>Order::STATUS_RETURN])
                ->sum('number');
            // tinh tong don hang
            $total = Order::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->sum('total');
            $total_sucess = Order::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['status'=>Order::STATUS_SUCCESS])
                ->sum('total');
            $total_error = Order::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['status'=>Order::STATUS_ERROR])
                ->sum('total');
            $total_tran = Order::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['status'=>Order::STATUS_TRANSPORT])
                ->sum('total');
            $total_ordered = Order::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['status'=>Order::STATUS_ORDERED])
                ->sum('total');
            $total_return = Order::find()
                ->andWhere('created_at >= :start')->addParams([':start' => $to_day])
                ->andWhere('created_at <= :end')->addParams([':end' => $end_day])
                ->andWhere(['status'=>Order::STATUS_RETURN])
                ->sum('total');

            $report = new Report();
            $report->date = $to_day_date;
            $report->total = $total;
            $report->number = $number;
            $report->number_error = $number_error;
            $report->number_ordered = $number_order;
            $report->number_return = $number_return;
            $report->number_success = $number_success;
            $report->number_tranport= $number_tran;
            $report->total_error = $total_error;
            $report->total_ordered = $total_ordered;
            $report->total_return = $total_return;
            $report->total_success = $total_sucess;
            $report->total_tranport = $total_tran;
            $report->save();

            $transaction->commit();
            print "Hoan thanh chay bao cao \n";

        } catch (Exception $e) {
            $transaction->rollBack();
            print "Da co loi xay ra";
            print $e;
        }
    }
}
