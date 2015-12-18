<?php

namespace backend\controllers;

use Yii;
use backend\models\Category;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\BackendController;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BackendController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $parent_category = [];
        $get_categorys = [];
        $get_category = Category::getCateory($model->parent_category);
        
        if(!empty($get_category)){ // cek jika parent nya adalah level pertama sperti kategori produk , kategori berita
            $get_categorys = Category::getCategories($get_category->parent_category);
            if(!empty($get_categorys)){
                $model->sub_category = $model->parent_category;
            }

            if(!empty($get_category) && ($get_category->parent_category !== 0 && $get_category->parent_category !== '')){
                $parent_category = Category::getParentCategorys($get_category->id);
                $model->parent_category = $get_category->parent_category;
            }else{
                $parent_category = Category::getParentCategorys($model->id);
//                echo '<pre>';print_r($parent_category);die;
            }
        }else{
            $parent_category = Category::getParentCategorys($model->parent_category);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'parent_category'  =>  $parent_category,
                'sub_categorys'    =>  $get_categorys
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAjaxlihatsubcat(){
        if(Yii::$app->request->isAjax){
            $parent = $_POST['parent'];
            $id = $_POST['id'];
            $option = "<option value>-- Pilih --</option>";
            if(!empty($parent)){
                $category = Category::getCategories($parent, $id);
                if(!empty($category)){
                    $cat_id = '';
                    foreach ($category as $i=>$cat){
                        if($cat['id_level2'] !== $cat_id){
                            $option .= "<option value='".$cat['id_level2']."'>".$cat['level2']."</option>";
                        }
                        $cat_id = $cat['id_level2'];
                    }
                }
            }
            
            return $option;
        }
    }
}
