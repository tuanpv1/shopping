<?php
namespace frontend\models;

use common\helpers\ForumHelper;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $fullname;
    public $address;
    public $email;
    public $password;
    public $confirm_password;
    public $type;
    public $phone;
    public $captcha;
    public $accept;
    public $birthday;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username'], 'required','message'=>'Tên đăng nhập không được để trống.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required','message'=>'Tên đăng nhập không được để trống.'],
            ['birthday', 'default', 'value' => null],
            ['email', 'email', 'message' => 'Địa chỉ email không hợp lệ!'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Tài khoản email của bạn đã được đăng ký trên hệ thống!'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Mật khẩu phải tối thiểu 6 ký tự'],
            ['confirm_password', 'required','message'=>'Xác nhận mật khẩu không được để trống.'],
            ['password','required','message'=>'Mật khẩu không được để trống.'],
            ['address','required','message'=>'Địa chỉ không được để trống.'],

            [
                ['confirm_password'],
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Xác nhận mật khẩu không khớp',

            ],
            ['accept', 'compare', 'compareValue' => 1, 'message' => ''],
            [['address'], 'safe'],
            [['phone'], 'integer', 'message' => 'Số điện thoại phải là kiểu số'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Tên đăng nhập',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'address' => 'Địa chỉ',
            'password' => 'Mật khẩu',
            'confirm_password' => 'Xác nhận mật khẩu',
            'accept' => 'Vui lòng đồng ý với quy định và điều khoản của trang (*)'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->address = $this->address;
            $user->phone = $this->phone;
            $user->birthday = $this->birthday;
            $user->password_reset_token = $this->password;
            $user->type = User::TYPE_USER;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            return $user->save() ? $user : null;

    }
}
