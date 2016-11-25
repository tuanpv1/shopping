<?php

namespace backend\controllers;

use backend\models\Image;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex($is_banner)
    {
        $searchModel = new ProductSearch();
        $searchModel->is_banner = $is_banner;
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'is_banner'=>$is_banner,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $imageModel = new Image();
        $images = $model->getImages();
        $imageProvider = new ArrayDataProvider([
            'key' => 'name',
            'allModels' => $images,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'model' => $model,
            'active'=>1,
            'imageModel' => $imageModel,
            'imageProvider' => $imageProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($is_banner)
    {
        $model = new Product();
        $thumbnailInit = [];
        $imageDesInit = [];
        $thumbnailPreview = [];
        $imageDesPreview = [];
        if ($model->load(Yii::$app->request->post())) {
            $model->is_banner = $is_banner;
            $thumbnails = UploadedFile::getInstances($model, 'thumbnail');
            $imageDes = UploadedFile::getInstances($model, 'image_des');
            $images = [];
            if (count($thumbnails) > 0) {
                foreach ($thumbnails as $image) {
                    $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $image->extension;
                    if ($image->saveAs(Yii::getAlias('@webroot') . "/" . Yii::getAlias('@image_product') . "/" . $file_name)) {
                        $new_file['name'] = $file_name;
                        $new_file['type'] = Product::IMAGE_TYPE_THUMBNAIL;
                        $new_file['size'] = $image->size;
                        $images[] = $new_file;
                    }
                }

            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Ảnh đại diện không được để trống'));
                return $this->render('create', [
                    'model' => $model,
                    'thumbnailInit' => $thumbnailInit,
                    'thumbnailPreview' => $thumbnailPreview,
                    'imageDesInit' => $imageDesInit,
                    'imageDesPreview' => $imageDesPreview,
                    'is_banner'=>$is_banner,
                ]);
            }
            if (count($imageDes) > 0) {
                foreach ($imageDes as $image) {
                    $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $image->extension;
                    if ($image->saveAs(Yii::getAlias('@webroot') . "/" . Yii::getAlias('@image_product') . "/" . $file_name)) {
                        $new_file['name'] = $file_name;
                        $new_file['type'] = Product::IMAGE_TYPE_DES;
                        $new_file['size'] = $image->size;
                        $images[] = $new_file;
                    }
                }
            }
            $old_images = Product::convertJsonToArray($model->image);
            $model->image = Json::encode(ArrayHelper::merge($old_images, $images));
            if($model->save(false)){
                Yii::$app->session->setFlash('success', 'Thêm sản phẩm thành công!');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('error', 'Thêm sản phẩm không thành công!');
                Yii::$app->getErrorHandler();
                return $this->render('create', [
                    'model' => $model,
                    'thumbnailInit' => $thumbnailInit,
                    'thumbnailPreview' => $thumbnailPreview,
                    'imageDesInit' => $imageDesInit,
                    'imageDesPreview' => $imageDesPreview,
                    'is_banner'=>$is_banner,
                ]);
            }
        }else{
            return $this->render('create', [
                'model' => $model,
                'thumbnailInit' => $thumbnailInit,
                'thumbnailPreview' => $thumbnailPreview,
                'imageDesInit' => $imageDesInit,
                'imageDesPreview' => $imageDesPreview,
                'is_banner'=>$is_banner,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $thumbnailInit = [];
        $imageDesInit = [];
        $thumbnailPreview = [];
        $imageDesPreview = [];
        $images = Product::convertJsonToArray($model->image);
        $old_images = Product::convertJsonToArray($model->image);
        foreach ($images as $key => $row) {
            $key = $key + 1;
            $urlDelete = Yii::$app->urlManager->createAbsoluteUrl(['/product/delete-image', 'name' => $row['name'], 'type' => $row['type'], 'id' => $id]);
            $name = $row['name'];
            $type = $row['type'];
            $value = ['caption' => $name, 'width' => '120px', 'url' => $urlDelete, 'key' => $name];
            $host_file = ((strpos($row['name'], 'http') !== false) || (strpos($row['name'], 'https') !== false)) ? $row['name'] : Yii::getAlias('@web/image_product/') . $row['name'];
            $preview = Html::img($host_file, ['class' => 'file-preview-image']);
            switch ($row['type']) {
                case (Product::IMAGE_TYPE_THUMBNAIL):
                    $thumbnailPreview[] = $preview;
                    $thumbnailInit[] = $value;
                    break;
                case (Product::IMAGE_TYPE_DES):
                    $imageDesInit[] = $value;
                    $imageDesPreview[] = $preview;
                    break;
            }
        }
        $errors = $model->errors;
        if ($model->load(Yii::$app->request->post())) {

            $thumbnails = UploadedFile::getInstances($model, 'thumbnail');
            $imageDes = UploadedFile::getInstances($model, 'image_des');
            $images = [];
            if (count($thumbnails) > 0) {
                foreach ($thumbnails as $image) {
                    $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $image->extension;
                    if ($image->saveAs(Yii::getAlias('@webroot') . "/" . Yii::getAlias('@image_product') . "/" . $file_name)) {
                        $new_file['name'] = $file_name;
                        $new_file['type'] = Product::IMAGE_TYPE_THUMBNAIL;
                        $new_file['size'] = $image->size;
                        $images[] = $new_file;
                    }
                }

            }
            if (count($imageDes) > 0) {
                foreach ($imageDes as $image) {
                    $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $image->extension;
                    if ($image->saveAs(Yii::getAlias('@webroot') . "/" . Yii::getAlias('@image_product') . "/" . $file_name)) {
                        $new_file['name'] = $file_name;
                        $new_file['type'] = Product::IMAGE_TYPE_DES;
                        $new_file['size'] = $image->size;
                        $images[] = $new_file;
                    }
                }
            }
            $model->image = Json::encode(ArrayHelper::merge($old_images, $images));
//            echo"<pre>";print_r($model->image);die();
            if($model->update(false)){
                Yii::$app->session->setFlash('success', 'Cập nhật sản phẩm thành công!');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
//                echo"<pre>";print_r($errors);die();
                Yii::$app->session->setFlash('error', 'Cập nhật sản phẩm không thành công!');
                return $this->render('update', [
                    'model' => $model,
                    'thumbnailInit' => $thumbnailInit,
                    'thumbnailPreview' => $thumbnailPreview,
                    'imageDesInit' => $imageDesInit,
                    'imageDesPreview' => $imageDesPreview,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'thumbnailInit' => $thumbnailInit,
                'thumbnailPreview' => $thumbnailPreview,
                'imageDesInit' => $imageDesInit,
                'imageDesPreview' => $imageDesPreview,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->status == Product::STATUS_ACTIVE){
            Yii::$app->session->setFlash('error', 'Không được xóa sản phẩm đang ở trạng thái hoạt động!');
            return $this->render('view',['id'=> $id]);
        }
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('error', 'Xóa sản phẩm thành công');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $product_id = Yii::$app->request->get('id');
        $name = Yii::$app->request->get('name');

        if (!$product_id || !$name) {
            return [
                'success' => false,
                'message' => 'Thiếu tham số!',
                'error' => 'Thiếu tham số!',
            ];
        }
        $content = $this->findModel($product_id);
        if (!$content) {
            return [
                'success' => false,
                'message' => 'Không thấy nội dung!',
                'error' => 'Không thấy nội dung!',
            ];
        } else {
            $index = -1;
            $images = Product::convertJsonToArray($content->image);
            Yii::trace($images);
            foreach ($images as $key => $row) {
                if ($row['name'] == $name) {
                    $index = $key;
                }
            }
            if ($index == -1) {
                return [
                    'success' => false,
                    'message' => 'Không thấy ảnh!',
                    'error' => 'Không thấy ảnh!',
                ];
            } else {
                array_splice($images, $index, 1);
                Yii::trace($images);
                $content->image = Json::encode($images);
                if ($content->save(false)) {

                    return [
                        'success' => true,
                        'message' => 'Xóa ảnh thành công',
                    ];
                }else{
                    return [
                        'success' => false,
                        'message' => $content->getErrors(),
                    ];
                }
            }
        }

    }
}
