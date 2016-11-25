<?php
namespace backend\models;

use common\models\OrderDetail;
use common\models\Report;
use DateTime;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class FormReport extends Model
{
    public $to_date;
    public $from_date;
    public $content = null;
    public $dataProvider;

    public function rules()
    {
        return [
            [['from_date', 'to_date', 'content'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'to_date' => 'Từ Ngày',
            'from_date' => 'Đến Ngày',
        ];
    }

    public function generateReport()
    {
        if ($this->from_date == '' || $this->to_date == '') {
            $to_date = (new DateTime('now'))->setTime(0, 0)->format('Y-m-d H:i:s');
            $from_date = (new DateTime('now'))->setTime(0, 0)->modify('-7 days')->format('Y-m-d H:i:s');
        } else {
            if ($this->to_date != '' && DateTime::createFromFormat("d/m/Y", $this->to_date)) {
                $to_date = DateTime::createFromFormat("d/m/Y", $this->to_date)->setTime(0, 0)->format('Y/m/d H:i:s');
            } else {
                $to_date = (new DateTime('now'))->setTime(0, 0)->format('Y-m-d H:i:s');
            }
            if ($this->from_date != '' && DateTime::createFromFormat("d/m/Y", $this->from_date)) {
                $from_date = DateTime::createFromFormat("d/m/Y", $this->from_date)->setTime(0, 0)->format('Y-m-d H:i:s');
            } else {
                $from_date = (new DateTime('now'))->setTime(0, 0)->format('Y-m-d H:i:s');
            }
        }

        $report_daily = Report::find()
            ->andwhere('date >= :p_from_date', [':p_from_date' => $from_date])
            ->andWhere('date <= :p_to_date', [':p_to_date' => $to_date])
            ->groupBy('date');

        $this->content = $report_daily;
    }
}
