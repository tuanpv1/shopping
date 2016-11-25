<?php

namespace common\models;

use backend\models\Image;
use Yii;
use yii\base\InvalidParamException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $image
 * @property string $name
 * @property string $des
 * @property integer $price
 * @property integer $id_category
 * @property integer $id_produce
 * @property integer $is_banner
 * @property string $chip
 * @property string $type_ram
 * @property string $type_hdd
 * @property string $size
 * @property integer $touch
 * @property string $graphics
 * @property string $pin
 * @property string $weight
 * @property string $os
 * @property string $Processor
 * @property string $type_cpu
 * @property string $product_cpu
 * @property string $speed_cpu
 * @property string $cache
 * @property string $speed_max
 * @property string $motherboard
 * @property string $Chipset
 * @property string $technology_cpu
 * @property string $wifi
 * @property string $hdmi
 * @property string $color
 * @property string $webcam
 * @property integer $lan
 * @property integer $dvd
 * @property integer $sale
 * @property integer $speed_bus
 * @property integer $max_ram
 * @property integer $ram
 * @property integer $hdd
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10; // hien
    const STATUS_BLOCK = 1; //an

    const IMAGE_TYPE_THUMBNAIL = 1; //an
    const IMAGE_TYPE_DES = 2; //an

    const MAX_SIZE_UPLOAD = 1024*10*10; // dung lượng tối đa cho phép 10mb

    public $thumbnail;
    public $image_des;
    public  function  getListStatus(){
        $list1 = [
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_BLOCK => 'Ẩn',
        ];

        return $list1;
    }

    public static function formatNumber($number)
    {
        return (new \yii\i18n\Formatter())->asInteger($number);
    }

    public function getStatusName()
    {
        $lst = self::getListStatus();
        if (array_key_exists($this->status, $lst)) {
            return $lst[$this->status];
        }
        return $this->status;
    }

    public static function getListImageType()
    {
        return [
            self::IMAGE_TYPE_DES => 'Ảnh mô tả',
            self::IMAGE_TYPE_THUMBNAIL => 'Ảnh đại diện',
        ];
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
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['des'], 'string'],
            ['name', 'required','message'=>'Tên sản phẩm không được để trống'],
            ['id_category', 'required','message'=>'Nhà sản xuất không được để trống'],
            ['id_produce', 'required','message'=>'Nhà phân phối không được để trống'],
            ['price', 'required','message'=>'Giá không được để trống'],
            ['sale', 'required','message'=>'Sale không được để trống'],
//            ['image', 'required','message'=>'Ảnh đại diện được để trống'],
            [['thumbnail','image_des'],'safe'],
            [['image'],'string'],
            [['price', 'touch', 'lan','id_produce', 'dvd', 'sale', 'speed_bus', 'max_ram','is_banner' ,'ram', 'hdd', 'status','id_category', 'created_at', 'updated_at'], 'integer','message'=>'Vui lòng nhập số'],
            [[ 'name', 'chip', 'type_ram', 'type_hdd', 'size', 'graphics', 'pin', 'weight', 'os', 'Processor', 'type_cpu', 'product_cpu', 'speed_cpu', 'cache', 'speed_max', 'motherboard', 'Chipset', 'technology_cpu', 'wifi', 'hdmi', 'color', 'webcam'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Ảnh',
            'is_banner' => 'Đặt làm banner',
            'thumbnail' => 'Ảnh đại diện',
            'image_des' => 'Ảnh mô tả',
            'name' => 'Tên sản phẩm',
            'des' => 'Mô tả',
            'id_produce' => 'Nhà phân phối',
            'price' => 'Giá',
            'chip' => 'Chip',
            'type_ram' => 'Loại Ram',
            'id_category' => 'Hãng sản xuất',
            'type_hdd' => 'Kiểu ổ cứng',
            'size' => 'Kích thước màn hình',
            'touch' => 'Cảm ứng',
            'graphics' => 'Đồ họa',
            'pin' => 'Pin',
            'weight' => 'Cân nặng',
            'os' => 'Hệ điều hành',
            'Processor' => 'Vi xử lý',
            'type_cpu' => 'Loại CPU',
            'product_cpu' => 'Hãng sản xuất CPU',
            'speed_cpu' => 'Tốc độ CPU',
            'cache' => 'Bộ nhớ đệm',
            'speed_max' => 'Tốc độ tối đa',
            'motherboard' => 'Bo mạch chủ',
            'Chipset' => 'Chipset',
            'technology_cpu' => 'Công nghệ CPU',
            'wifi' => 'Wifi',
            'hdmi' => 'Cổng kết nối ',
            'color' => 'Màu sắc',
            'webcam' => 'Webcam',
            'lan' => 'Lan',
            'dvd' => 'Ổ DVD',
            'sale' => 'Sale',
            'speed_bus' => 'Tốc độ Bus',
            'max_ram' => 'Hỗ trợ Ram tối đa',
            'ram' => 'Dung lượng Ram',
            'hdd' => 'Dung lượng ổ cứng',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày thay đổi thông tin',
        ];
    }

    public static function convertJsonToArray($input)
    {
        $listImage = json_decode($input);

        $result = [];
        if (is_array($listImage)) {
            foreach ($listImage as $item) {
                $row['name'] = $item->name;
                $row['type'] = $item->type;
                $row['size'] = $item->size;
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getFirstImageLink()
    {
        $link = '';
        if (!$this->image) {
            return null;
        }
        $listImages = Product::convertJsonToArrayTP($this->image);
        foreach ($listImages as $key => $row) {
            $link = Url::to(Yii::getAlias('@web/image_product/') . $row['name'], true);
        }
        return $link;
    }

    public static function getImageFe($name){
//        echo  "<pre>";print_r($row);die();
        $link = Url::to(Yii::getAlias('@web/image_product/') . $name, true);
        return $link;
    }

    public static function getFirstImageLinkTP($image)
    {
        $link = '';
        if (!$image) {
            return null;
        }
        $listImages = Product::convertJsonToArrayTP($image);
        foreach ($listImages as $key => $row) {
            $link = Url::to(Yii::getAlias('@web/image_product/') . $row['name'], true);
        }
        return $link;
    }

    public static function convertJsonToArrayTp($input)
    {
        $listImage = json_decode($input);

        $result = [];
        if (is_array($listImage)) {
            foreach ($listImage as $item) {
                if ($item->type == 1) {
                    $row['name'] = $item->name;
                    $row['type'] = $item->type;
                    $row['size'] = $item->size;
                    $result[] = $row;
                }
            }
        }
        return $result;
    }

    public function getImages()
    {
        try {
            $res = [];
            $images = $this->convertJsonToArray($this->image);
            if ($images) {
                for ($i = 0; $i < count($images); $i++) {
                    $item = $images[$i];
                    $image = new Image();
                    $image->type = $item['type'];
                    $image->name = $item['name'];
                    $image->size = $item['size'];
                    array_push($res, $image);
                }
                return $res;
            }
        } catch (InvalidParamException $ex) {
            $images = null;
        }

        return $images;
    }

    public static function getOS($type){
        if($type == 1){
            return 'Windows';
        }
        if($type == 2){
            return 'Mac';
        }
        if($type == 3){
            return 'Free Os';
        }
    }
}
