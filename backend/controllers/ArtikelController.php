<?php

namespace backend\controllers;

use Yii;
use backend\models\Artikel;
use backend\models\ArtikelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\BackendController;

/**
 * ArtikelController implements the CRUD actions for Artikel model.
 */
class ArtikelController extends BackendController
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
     * Lists all Artikel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArtikelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = \Yii::$app->params['pageSizeGrid'];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Artikel model.
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
     * Creates a new Artikel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Artikel();
        $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post())) {
            $image1 = $model->uploadImage(1);
            $image2 = $model->uploadImage(2);
            $image3 = $model->uploadImage(3);
            $image4 = $model->uploadImage(4);
            $image5 = $model->uploadImage(5);
            $image6 = $model->uploadImage(6);
            $image7 = $model->uploadImage(7);
            $image8 = $model->uploadImage(8);
            $image9 = $model->uploadImage(9);
//            print_r(Yii::$app->request->post());die;
            if($model->save()){
                // upload only if valid uploaded file instance found
                if($image1 !== FALSE){
                    $path1 = $model->getImageFile($model->image1);
                    $image1->saveAs($path1);
                }
                if($image2 !== FALSE){
                    $path2 = $model->getImageFile($model->image2);
                    $image2->saveAs($path2);
                }
                if($image3 !== FALSE){
                    $path3 = $model->getImageFile($model->image3);
                    $image3->saveAs($path3);
                }
                if($image4 !== FALSE){
                    $path4 = $model->getImageFile($model->image4);
                    $image4->saveAs($path4);
                }
                if($image5 !== FALSE){
                    $path5 = $model->getImageFile($model->image5);
                    $image5->saveAs($path5);
                }
                if($image6 !== FALSE){
                    $path6 = $model->getImageFile($model->image6);
                    $image6->saveAs($path6);
                }
                if($image7 !== FALSE){
                    $path7 = $model->getImageFile($model->image7);
                    $image7->saveAs($path7);
                }
                if($image8 !== FALSE){
                    $path8 = $model->getImageFile($model->image8);
                    $image8->saveAs($path8);
                }
                if($image9 !== FALSE){
                    $path9 = $model->getImageFile($model->image9);
                    $image9->saveAs($path9);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Artikel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        
//        if (\Yii::$app->user->can('updatePost', ['post' => $model])) {
//            die('own');
//        }
        
        $oldFile1 = $model->getImageFile($model->image1);
        $oldFile2 = $model->getImageFile($model->image2);
        $oldFile3 = $model->getImageFile($model->image3);
        $oldFile4 = $model->getImageFile($model->image4);
        $oldFile5 = $model->getImageFile($model->image5);
        $oldFile6 = $model->getImageFile($model->image6);
        $oldFile7 = $model->getImageFile($model->image7);
        $oldFile8 = $model->getImageFile($model->image8);
        $oldFile9 = $model->getImageFile($model->image9);
        $oldImage1 = $model->image1;
        $oldImage2 = $model->image2;
        $oldImage3 = $model->image3;
        $oldImage4 = $model->image4;
        $oldImage5 = $model->image5;
        $oldImage6 = $model->image6;
        $oldImage7 = $model->image7;
        $oldImage8 = $model->image8;
        $oldImage9 = $model->image9;
        
        $model->img2 = 0;
        $model->img3 = 0;
        $model->img4 = 0;
        $model->img5 = 0;
        $model->img6 = 0;
        $model->img7 = 0;
        $model->img8 = 0;
        $model->img9 = 0;
        
        if ($model->load(Yii::$app->request->post())) {
            $image1 = $model->uploadImage(1);
            $image2 = $model->uploadImage(2);
            $image3 = $model->uploadImage(3);
            $image4 = $model->uploadImage(4);
            $image5 = $model->uploadImage(5);
            $image6 = $model->uploadImage(6);
            $image7 = $model->uploadImage(7);
            $image8 = $model->uploadImage(8);
            $image9 = $model->uploadImage(9);
            
            // revert back if image not valid
            if($image1 === FALSE){
                $model->image1 = $oldImage1;
            }
            if($image2 === FALSE){
                if($model->img2 == 1):
                    if(is_file($oldFile2)){
                        unlink($oldFile2);
                    }
                    $model->image2 = "";
                else:
                    $model->image2 = $oldImage2;
                endif;
            }
            if($image3 === FALSE){
                if($model->img3 == 1):
                    if(is_file($oldFile3)){
                        unlink($oldFile3);
                    }
                    $model->image3 = "";
                else:
                    $model->image3 = $oldImage3;
                endif;
            }
            if($image4 === FALSE){
                if($model->img4 == 1):
                    if(is_file($oldFile4)){
                        unlink($oldFile4);
                    }
                    $model->image4 = "";
                else:
                    $model->image4 = $oldImage4;
                endif;
            }
            if($image5 === FALSE){
                if($model->img5 == 1):
                    if(is_file($oldFile5)){
                        unlink($oldFile5);
                    }
                    $model->image5 = "";
                else:
                    $model->image5 = $oldImage5;
                endif;
            }
            if($image6 === FALSE){
                if($model->img6 == 1):
                    if(is_file($oldFile6)){
                        unlink($oldFile6);
                    }
                    $model->image6 = "";
                else:
                    $model->image6 = $oldImage6;
                endif;
            }
            if($image7 === FALSE){
                if($model->img7 == 1):
                    if(is_file($oldFile7)){
                        unlink($oldFile7);
                    }
                    $model->image7 = "";
                else:
                    $model->image7 = $oldImage7;
                endif;
            }
            if($image8 === FALSE){
                if($model->img8 == 1):
                    if(is_file($oldFile8)){
                        unlink($oldFile8);
                    }
                    $model->image8 = "";
                else:
                    $model->image8 = $oldImage8;
                endif;
            }
            if($image9 === FALSE){
                if($model->img9 == 1):
                    if(is_file($oldFile9)){
                        unlink($oldFile9);
                    }
                    $model->image9 = "";
                else:
                    $model->image9 = $oldImage9;
                endif;
            }
            
            if($model->save()){
                // upload jika image nya valid
                
                if($image1 !== FALSE){
                    if(is_file($oldFile1)){
                        unlink($oldFile1);
                    }
                    $path1 = $model->getImageFile($model->image1);
                    $image1->saveAs($path1);
                }
                if($image2 !== FALSE){
                    if(is_file($oldFile2)){
                        unlink($oldFile2);
                    }
                    $path2 = $model->getImageFile($model->image2);
                    $image2->saveAs($path2);
                }
                if($image3 !== FALSE){
                    if(is_file($oldFile3)){
                        unlink($oldFile3);
                    }
                    $path3 = $model->getImageFile($model->image3);
                    $image3->saveAs($path3);
                }
                if($image4 !== FALSE){
                    if(is_file($oldFile4)){
                        unlink($oldFile4);
                    }
                    $path4 = $model->getImageFile($model->image4);
                    $image4->saveAs($path4);
                }
                if($image5 !== FALSE){
                    if(is_file($oldFile5)){
                        unlink($oldFile5);
                    }
                    $path5 = $model->getImageFile($model->image5);
                    $image5->saveAs($path5);
                }
                if($image6 !== FALSE){
                    if(is_file($oldFile6)){
                        unlink($oldFile6);
                    }
                    $path6 = $model->getImageFile($model->image6);
                    $image6->saveAs($path6);
                }
                if($image7 !== FALSE){
                    if(is_file($oldFile7)){
                        unlink($oldFile7);
                    }
                    $path7 = $model->getImageFile($model->image7);
                    $image7->saveAs($path7);
                }
                if($image8 !== FALSE){
                    if(is_file($oldFile8)){
                        unlink($oldFile8);
                    }
                    $path8 = $model->getImageFile($model->image8);
                    $image8->saveAs($path8);
                }
                if($image9 !== FALSE){
                    if(is_file($oldFile9)){
                        unlink($oldFile9);
                    }
                    $path9 = $model->getImageFile($model->image9);
                    $image9->saveAs($path9);
                }
                
                
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                
            }
            
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Artikel model.
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
     * Finds the Artikel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Artikel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artikel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
