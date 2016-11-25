<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "produce".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_cat
 * @property string $address
 * @property integer $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Produce extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 10; // Còn liên kết
    const STATUS_BLOCK = 1; // không liên kết
    public  function  getListStatus(){
        $list1 = [
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_BLOCK => 'Tạm dừng',
        ];

        return $list1;
    }

    public function getStatusName()
    {
        $lst = self::getListStatus();
        if (array_key_exists($this->status, $lst)) {
            return $lst[$this->status];
        }
        return $this->status;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'produce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required','message'=>'Tên nhà phân phối không được để trống'],
            ['id_cat', 'required','message'=>'Hãng sản xuất không được để trống'],
            ['address', 'required','message'=>'Địa chỉ không được để trống'],
            [['id_cat', 'phone', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [
                'phone',
                'match', 'pattern' => '/^(0)\d{9,10}$/',
                'message' => 'Số điện thoại không hợp lệ - Định dạng số điện thoại bắt đầu với số 0, ví dụ 0912345678, 012312341234'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên nhà phân phối',
            'id_cat' => 'Hãng sản xuất',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày thay đổi thông tin',
        ];
    }
}
