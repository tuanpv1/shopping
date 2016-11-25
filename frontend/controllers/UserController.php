<?php

namespace frontend\controllers;

use common\models\OrderSearch;
use Yii;
use common\models\User;
use common\models\UserSearch;
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

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $avatar  = UploadedFile::getInstance($model, 'image');
                if ($avatar) {
                    $avatar_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $avatar->extension;
                    if ($avatar->saveAs(Yii::getAlias('@webroot') . "/" . Yii::getAlias('@avatar') . "/" . $avatar_name)) {
                        $model->image = $avatar_name;
                        if ($model->save()) {
                            Yii::$app->session->setFlash('success', 'Cập nhật thành công thông tin người dùng!');
                            return $this->redirect(['user/info']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', 'Lỗi hệ thống vui lòng thử lại');
                            Yii::error($model->getErrors());
                            return $this->redirect(['user/info']);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', 'Lỗi hệ thống, vui lòng thử lại');
                        return $this->redirect(['user/info']);
                    }
                }else {
                    $model->image = $avatar_old;
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', 'Cập nhật thành công thông tin người dùng');
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

            $model->setScenario('user-setting');

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post())) {
                $model->setPassword($model->setting_new_password);
                $model->password_reset_token = $model->setting_new_password;
                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Đổi mật khẩu thành công'));
                    return $this->redirect(['user/info']);
                } else {
                    Yii::warning($model->getErrors());
                    Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'Đổi mật khẩu không thành công'));
                    return $this->redirect(['user/info']);
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

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
