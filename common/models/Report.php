<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $id
 * @property string $date
 * @property integer $total
 * @property integer $number
 * @property integer $number_success
 * @property integer $number_error
 * @property integer $number_tranport
 * @property integer $number_return
 * @property integer $number_ordered
 * @property integer $total_success
 * @property integer $total_error
 * @property integer $total_tranport
 * @property integer $total_return
 * @property integer $total_ordered
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['total', 'number', 'number_success', 'number_error', 'number_tranport', 'number_return', 'number_ordered', 'total_success', 'total_error', 'total_tranport', 'total_return', 'total_ordered'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'total' => 'Total',
            'number' => 'Number',
            'number_success' => 'Number Success',
            'number_error' => 'Number Error',
            'number_tranport' => 'Number Tranport',
            'number_return' => 'Number Return',
            'number_ordered' => 'Number Ordered',
            'total_success' => 'Total Success',
            'total_error' => 'Total Error',
            'total_tranport' => 'Total Tranport',
            'total_return' => 'Total Return',
            'total_ordered' => 'Total Ordered',
        ];
    }
}
