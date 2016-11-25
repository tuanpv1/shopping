<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Product;
use DateTime;
use Yii;
use yii\web\Controller;
use frontend\models\Viewed;
use yii\db\mssql\PDO;
use yii\data\Pagination;
use yii\db\QueryTrait;

/**
 * Site controller
 */
class ProductController extends Controller
{
    public function actionDetail($id){

        $model = Product::findOne($id);
        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();
        $date = (new DateTime('now'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $date_from = (new DateTime('now'))->modify('-7 days')->setTime(0, 0)->format('Y-m-d H:i:s');
        $now = strtotime($date);
        $from = strtotime($date_from);

        // tạo session để lấy các sản phẩm đã xem
        $viewed = new Viewed();
        $viewed->addViewed($id,$model);
        $session = Yii::$app->session;
        $viewedInfo = $session['viewed'];
//        echo"<pre>";print_r($viewedInfo);die();
        return $this->render('detail',[
            'model'=>$model,
            'cat'=>$cat,
            'now'=>$now,
            'from'=>$from,
        ]);
    }

    public function actionIndex(){


        $query = Product::find()->where(['status' => Product::STATUS_ACTIVE]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pageSize = Yii::$app->params['page_size'];
        $pages->setPageSize($pageSize);
        $models = $query->offset($pages->offset)
            ->limit(9)
            ->all();

        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();

        $date = (new DateTime('now'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $date_from = (new DateTime('now'))->modify('-7 days')->setTime(0, 0)->format('Y-m-d H:i:s');
        $now = strtotime($date);
        $from = strtotime($date_from);

        return $this->render('index',[
            'product'=>$models,
            'cat'=>$cat,
            'now'=>$now,
            'from'=>$from,
            'totalCountIndex'=>$pages,
        ]);
    }

    public function actionSale(){
        $date = (new DateTime('now'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $date_from = (new DateTime('now'))->modify('-7 days')->setTime(0, 0)->format('Y-m-d H:i:s');
        $now = strtotime($date);
        $from = strtotime($date_from);

        $query = Product::find()
            ->andWhere(['status'=>Product::STATUS_ACTIVE])
            ->andWhere("sale != :sale")->addParams([':sale'=>0])
            ->orderBy(['created_at'=>'DESC']);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pageSize = Yii::$app->params['page_size'];
        $pages->setPageSize($pageSize);
        $models = $query->offset($pages->offset)
            ->limit(9)
            ->all();

        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();

        return $this->render('index',[
            'product'=>$models,
            'cat'=>$cat,
            'now'=>$now,
            'from'=>$from,
            'totalCountIndex'=>$pages,
        ]);
    }


    public function actionCategory($id_cat){
        $date = (new DateTime('now'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $date_from = (new DateTime('now'))->modify('-7 days')->setTime(0, 0)->format('Y-m-d H:i:s');
        $now = strtotime($date);
        $from = strtotime($date_from);

        $query = Product::find()
            ->andWhere(['status'=>Product::STATUS_ACTIVE])
            ->andWhere(['id_category'=>$id_cat])
            ->orderBy(['created_at'=>'DESC']);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pageSize = Yii::$app->params['page_size'];
        $pages->setPageSize($pageSize);
        $models = $query->offset($pages->offset)
            ->limit(9)
            ->all();

        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();
        return $this->render('index',[
            'product'=>$models,
            'cat'=>$cat,
            'now'=>$now,
            'from'=>$from,
            'totalCountIndex'=>$pages,
        ]);
    }

    public function actionSearch($key){
        $page = $this->getParameter('page', 1);
        $rows_per_page = $this->getParameter('per-page', 9);

        $page_start = ($page - 1) * $rows_per_page;
        $page_end = $rows_per_page;
        $keyword = strtolower($key);
        $sql = "select distinct id,name,image,sale,price,ram,technology_cpu,type_hdd,created_at,hdd from product WHERE status= 10 and lower(name) LIKE :keyword";
        $sql .= " LIMIT " . $page_start . " , " . $page_end;
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(":keyword", "%$keyword%", PDO::PARAM_STR);
        $dataReader = $command->query();
        $product = null;
        $i = 0;
        foreach ($dataReader as $item) {
            $product[$i] = new \stdClass();
            $product[$i]->id = $item['id'];
            $product[$i]->name = $item['name'];
            $product[$i]->image = $item['image'];
            $product[$i]->sale = $item['sale'];
            $product[$i]->price = $item['price'];
            $product[$i]->ram = $item['ram'];
            $product[$i]->technology_cpu = $item['technology_cpu'];
            $product[$i]->type_hdd = $item['type_hdd'];
            $product[$i]->created_at = $item['created_at'];
            $product[$i]->hdd = $item['hdd'];
            $i++;
        }
        $totalCount = $this->countNumber($keyword);
        $date = (new DateTime('now'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $date_from = (new DateTime('now'))->modify('-7 days')->setTime(0, 0)->format('Y-m-d H:i:s');
        $now = strtotime($date);
        $from = strtotime($date_from);
        $cat = Category::find()->andWhere(['status'=>Category::STATUS_ACTIVE])->all();
        return $this->render('index', [
            'product' => $product,
            'totalCount' => $totalCount,
            'cat'=>$cat,
            'now'=>$now,
            'from'=>$from,
        ]);
    }

    public function countNumber($keyword)
    {

        $sql = "select distinct id,name,image,sale,price,ram,technology_cpu,type_hdd,created_at,hdd from product WHERE status= 10 and lower(name) LIKE :keyword";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(":keyword", "%$keyword%", PDO::PARAM_STR);
        $rowCount = $command->execute();
        return $rowCount;
    }

    public function getParameter($param_name, $default = null) {
        return \Yii::$app->request->get($param_name, $default);
    }
}