<?php

namespace frontend\controllers;

use common\models\OrderSearch;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionInfo()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }else{
            $id = Yii::$app->user->id;
            $searchModel = new OrderSearch();
            $params = Yii::$app->request->queryParams;
            $params['OrderSearch']['user_id'] = $id;
            $dataProvider = $searchModel->search($params);
            return $this->render('info', [
                'model' => $this->findModel($id),
                'active'=>1,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionUpdate(){
        if(Yii::$app->user){
            $id = Yii::$app->user->id;
            $model = User::findOne($id);

            $avatar_old = $model->image;

            if (isset($_POST['check_post'])) {
                $model->fullname = $_POST['full_name'];
                $model->email = $_POST['user_email'];
                $model->phone = $_POST['user_phone'];
                $model->address = $_POST['user_adress'];
                $model->gender = $_POST['user_gender'];
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Cập nhật thành công thông tin người dùng!');
                    return $this->redirect(['user/info']);
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Lỗi hệ thống vui lòng thử lại');
                    Yii::error($model->getErrors());
                    return $this->redirect(['user/info']);
                }
            } else {
                return $this->render('update', [
                    'model' => $model
                ]);
            }
        }else{
            return $this->render('site/login');
        }
    }

    public function actionChangePassword()
    {
        if(Yii::$app->user){
            $id = Yii::$app->user->id;

            $model = User::findOne($id);

            if (isset($_POST['pass'])) {
                $pass = $_POST['pass'];
                $model->setPassword($pass);
                $model->password_reset_token = $pass;
                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Đổi mật khẩu thành công'));
                    return Json::encode(['success' => true]);
                } else {
                    Yii::warning($model->getErrors());
                    Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'Đổi mật khẩu không thành công'));
                    return Json::encode(['success' => false]);
                }
            } else {
                return $this->render('change-password', [
                    'model' => $model
                ]);
            }
        }else{
            return $this->render('site/login');
        }
    }

    public function actionChangeAvatar()
    {
        if(Yii::$app->user){
            $id = Yii::$app->user->id;
            $model = User::findOne($id);
            $avatar_old = $model->image;
            if ($model->load(Yii::$app->request->post())) {
                $avatar  = UploadedFile::getInstance($model, 'image');
                if ($avatar) {
                    $avatar_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $avatar->extension;
                    if ($avatar->saveAs(Yii::getAlias('@webroot') . "/" . Yii::getAlias('@avatar') . "/" . $avatar_name)) {
                        $model->image = $avatar_name;
                        if ($model->save(false)) {
                            Yii::$app->session->setFlash('success', 'Cập nhật ảnh đại diện thành công thông!');
                            return $this->redirect(['user/info']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', 'Lỗi hệ thống vui lòng thử lại');
                            Yii::error($model->getErrors());
                            return $this->render('change-avatar', [
                                'model' => $model
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', 'Lỗi hệ thống 1, vui lòng thử lại');
                        return $this->render('change-avatar', [
                            'model' => $model
                        ]);
                    }
                }
            } else {
                return $this->render('change-avatar', [
                    'model' => $model
                ]);
            }
        }else{
            return $this->render('site/login');
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
