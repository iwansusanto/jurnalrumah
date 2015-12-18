<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use backend\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'] // important
    ]); ?>
    
    <?=
    $form->field($model, 'pict')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->pict) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->pict, "", $kategori = "user")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
    ]);
    ?>

    <?= $form->field($model, 'nama_depan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_belakang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'readonly'  =>  (!$model->isNewRecord) ? true : false]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput() ?>
    
    <?= $form->field($model, 'jenis_kelamin',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList(User::getJenisKel(), [
                    'prompt'    =>  '-- Pilih --'
                ]) ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'password')->textInput() ?>
    <?php else: ?>
        <?= $form->field($model, 'oldpass')->textInput() ?>
        <?= $form->field($model, 'newpass')->textInput() ?>
        <?= $form->field($model, 'retypepass')->textInput() ?>
    <?php endif; ?>
    
    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type_user',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList(User::getType(), [
                    'prompt'    =>  '-- Pilih --'
                ]) ?>
    
    <?= $form->field($model, 'newsletter',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList([1   =>  'Ya', 0 =>  'Tidak'], [
//                    'prompt'    =>  '-- Pilih --'
                ]) ?>
    
    <?= $form->field($model, 'status',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList(User::getStatus(), [
                    'prompt'    =>  '-- Pilih --'
                ]) ?>
    <?php
//        $form->field($model, 'role',[
//                            'template'  => "{label}{input}\n{hint}\n{error}"
//                ])->dropDownList([1   =>  'Admin', 0 =>  'Biasa'], [
//                    'prompt'    =>  '-- Pilih --'
//                ]);
    ?>
    <?= $form->field($model, 'role',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList(ArrayHelper::map(AuthItem::getRoles(), 'name', 'name'), [
                    'prompt'    =>  '-- Pilih --'
                ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
