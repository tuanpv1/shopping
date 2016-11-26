<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Order;
use common\models\OrderDetailSearch;
use common\models\Product;
use common\models\User;
use DateTime;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $date = (new DateTime('now'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $date_from = (new DateTime('now'))->modify('-7 days')->setTime(0, 0)->format('Y-m-d H:i:s');
        $now = strtotime($date);
        $from = strtotime($date_from);
        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();
        $product_new = Product::find()
            ->andWhere(['status'=>Product::STATUS_ACTIVE])
            ->andWhere(['sale'=>0])
            ->andWhere(['>','created_at',$from])
            ->andWhere(['<','created_at',$now])
            ->orderBy(['created_at'=>'DESC'])
            ->limit(6)
            ->all();
        $product_banner = Product::find()->andWhere(['status'=>Product::STATUS_ACTIVE])->andWhere(['is_banner'=>2])->all();
        $sale = Product::find()
            ->andWhere(['status'=>Product::STATUS_ACTIVE])
            ->andWhere("sale != :sale")->addParams([':sale'=>0])
            ->orderBy(['created_at'=>'DESC'])
            ->limit(6)
            ->all();
        return $this->render('index',[
            'cat'=>$cat,
            'product_new'=>$product_new,
            'product_banner' => $product_banner,
            'sale' => $sale,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionCheckUser(){
        if(Yii::$app->user->isGuest){
            return 1;
        }else{
            return 2;
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', 'Đăng kí tài khoản thành công.');
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $searchModel = new OrderDetailSearch();
        $params = Yii::$app->request->queryParams;
        $params['OrderDetailSearch']['order_id']= $id;
        $dataProvider = $searchModel->search($params);
        $model = Order::findOne($id);
        return $this->render('view', [
            'model' =>$model ,
            'active'=>1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCheckPass()
    {
        $id = Yii::$app->user->id;
        $password_hash = User::findOne($id)->password_hash;
        $old = $_POST['old'];
        $rs = Yii::$app->security->validatePassword($old, $password_hash);
        if($rs){
            return Json::encode(['success' => true]);
        }else{
            return Json::encode(['success' => false]);
        }
    }
}
