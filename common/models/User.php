<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    //GIỚI TÍNH
    const STATUS_MALE = 1;
    const STATUS_FEMALE = 2;
    //TRẠNG THÁI
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCK = 1;
    // KIỂU NGƯỜI DÙNG
    const TYPE_USER = 10;
    const TYPE_ADMIN = 9;

    public $password;
    public $confirm_password;
    public $new_password;
    public $old_password;
    public $setting_new_password;

    public  function  getListType(){
        $list2 = [
            self::TYPE_USER => 'Người dùng',
            self::TYPE_ADMIN => 'Quản trị viên',
        ];

        return $list2;
    }

    public function getTypeName()
    {
        $lst = self::getListType();
        if (array_key_exists($this->type, $lst)) {
            return $lst[$this->type];
        }
        return $this->type;
    }

    public static function getTypeNameByID($type)
    {
        $lst = self::getListType();
        if (array_key_exists($type, $lst)) {
            return $lst[$type];
        }
        return $type;
    }
    public function getAvatar()
    {
        //TODO get partner avatar
        $pathLink = Yii::getAlias("@web/avatar/");
        $filename = null;
        if ($this->image) {
            $filename = $this->image;
        }
        if (!$filename) {
            $pathLink = Yii::getAlias("@web/img/");
            $filename = 'avt_df.png';
        }

        return Url::to($pathLink . $filename, true);

    }

    public function getListGender()
    {
        $list = [
            self::STATUS_MALE   => 'Nam',
            self::STATUS_FEMALE => 'Nữ',
        ];

        return $list;
    }
    public static function getGenderName($type)
    {
        $lst = self::getListGender();
        if (array_key_exists($type, $lst)) {
            return $lst[$type];
        }
        return $type;
    }

    public  function  getListStatus(){
        $list1 = [
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_BLOCK => 'Tạm khóa',
            self::STATUS_DELETED => 'Xóa',
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

    public static function getOld($birthday)
    {
        if($birthday != null) {
            $y = date('Y', strtotime($birthday));
            $ynow = date('Y');
            $old = $ynow - $y;
            return $old;
        }
        else {
            return null;
        }
    }

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username'], 'required','message'=>'Tên đăng nhập không được để trống'],
            ['username', 'unique', 'message' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message'=> 'Email không được để trống'],
            ['email', 'unique', 'message' => 'Tài khoản email của bạn đã được đăng ký trên hệ thống!'],
            ['email', 'email', 'message' => 'Địa chỉ email không hợp lệ!'],

            [['gender'],'integer'],
            ['birthday', 'default', 'value' => null],

            [['fullname', 'address','password_reset_token'], 'string', 'max' => 255],

            ['birthday', 'default', 'value' => null],
            [['image'], 'file', 'extensions' => ['png', 'jpg','jpeg', 'gif'], 'maxSize' => 1024 * 1024 * 10, 'tooBig' => 'Dung lượng ảnh vượt quá 10mb'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_BLOCK]],
            [['type'],'integer'],
            [['type'],'required','on'=>'create'],
            [
                'phone',
                'match', 'pattern' => '/^(0)\d{9,10}$/',
                'message' => 'Số điện thoại không hợp lệ - Định dạng số điện thoại bắt đầu với số 0, ví dụ 0912345678, 012312341234'
            ],

            [['password_hash'], 'required', 'message'=>'Mật khẩu không được để trống.'],
            [['password_hash'], 'string','min'=>6, 'tooShort'=>'Mật khẩu tối thiểu 6 kí tự.'],

            [['setting_new_password'], 'required', 'message'=>'Mật khẩu mới không được để trống.','on' => 'user-setting'],
            [['setting_new_password'], 'string','min'=>6, 'tooShort'=>'Mật khẩu mới tối thiểu 6 kí tự.','on' => 'user-setting'],
            [['old_password'], 'required', 'message'=>'Mật khẩu cũ không được để trống.','on' => 'user-setting'],
            ['old_password', 'validator_password','on' => 'user-setting'],
            [['confirm_password'], 'required', 'message' => 'Xác nhận mật khẩu mới không được để trống.','on' => 'user-setting'],
        ];
    }

    public function validator_password($attribute, $params)
    {
        if (!$this->validatePassword($this->old_password)) {
            $this->addError('old_password', 'Mật khẩu cũ không đúng.');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Tên đăng nhập'),
            'fullname' => Yii::t('app', 'Tên đầy đủ'),
            'phone' => Yii::t('app', 'Số điện thoại'),
            'image' => Yii::t('app', 'Ảnh đại diện'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Địa chỉ'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Mật khẩu'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Trạng thái'),
            'created_at' => Yii::t('app', 'Ngày tham gia'),
            'updated_at' => Yii::t('app', 'Ngày thay đổi thông tin'),
            'type' => Yii::t('app', 'Loại người dùng'),
            'access_login_token' => Yii::t('app', 'Access Login Token'),
            'setting_new_password' => Yii::t('app', 'Mật khẩu mới'),
            'old_password' => Yii::t('app', 'Mật khẩu cũ'),
            'confirm_password' => Yii::t('app', 'Xác nhận mật khẩu'),
            'new_password' => Yii::t('app', 'Mật khẩu mới'),
            'gender' => Yii::t('app', 'Giới tính'),
            'birthday' => Yii::t('app', 'Ngày sinh'),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
