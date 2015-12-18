<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>

<div class="form-cariberita">
    <?php
//        $form = ActiveForm::begin([
//                    'id' => 'cariberita-form',
//                    'action' => \Yii::$app->urlManager->createAbsoluteUrl(['berita/cariberita']),
//                    'method'    =>  'GET',
//                    'options' => [
//                        'class' => '',
//        ]]);
//        ?>
        
        <?php // Html::activeTextInput($model, 'txtcari', ['placeholder' => 'Cari Berita', 'class' => 'txt-cariberita left']); ?>
        <?php // Html::submitButton('Cari', ['class' => 'btn-cariberita left', 'name' => 'btn-cariberita']) ?>
    
    <?php // ActiveForm::end();  // end form   ?>
    <?= Html::beginForm(
                \Yii::$app->urlManager->createAbsoluteUrl(['berita/cariberita']),
                'get', 
                ['id' => 'cariberita-form']);?>
        
        <input id="query" type="text" class="txt-cariberita left" placeholder="<?=yii::t('app','Cari Berita');?>" name="query" value="<?= Html::encode(\Yii::$app->getRequest()->getQueryParam('query',""));?>" />
        
        <button type="submit" class="btn-cariberita left"><?=yii::t('app','Cari');?></button>
    <?= Html::endForm(); ?>
</div>
