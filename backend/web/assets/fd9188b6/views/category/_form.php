<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'parent_category',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList($model->isNewRecord ? ArrayHelper::map(Category::getParentCategorys(), 'id', 'nama') : ArrayHelper::map($parent_category, 'id', 'nama'), [
                    'prompt'    =>  '-- Pilih --',
                    'onChange'  =>  '
                                        var csrfToken = $("meta[name=\'csrf-token\']").attr(\'content\');
                                        $.ajax({
                                            url :   "'.Yii::$app->urlManager->createAbsoluteUrl('category/ajaxlihatsubcat').'",
                                            dataType: "html",
                                            type: "POST",
                                            data: {parent : $(this).val(), id: $("#'.Html::getInputId($model, 'id').'").val() ,_csrf : csrfToken},
                                            beforeSend: function(){
                                                $("input[type=\'submit\']").attr("disabled","disabled");
                                                $("#'.Html::getInputId($model, 'sub_category').'").addClass(\'loader-icon-dropdown\');
                                                $("#'.Html::getInputId($model, 'sub_category').'").prop("disabled", true);
                                            },
                                            success: function(data){
                                                $("#'.Html::getInputId($model, 'sub_category').'").removeClass(\'loader-icon-dropdown\');
                                                $("#'.Html::getInputId($model, 'sub_category').'").prop("disabled", false);
                                                $("#'.Html::getInputId($model, 'sub_category').'").html(data);
                                                $("input[type=\'submit\']").removeAttr("disabled");
                                                $(".subcategory").removeClass(\'hidden\');
                                            }
                                        });
                                            '
                ]) ?>
    
    <?php $model->isNewRecord ? $statusField = 'hidden' : (!empty($sub_categorys) ? $statusField = '' : $statusField = 'hidden')    ?>
    <div class="subcategory <?= $statusField ?>">
        <?= $form->field($model, 'sub_category',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList($model->isNewRecord ? [] : ArrayHelper::map($sub_categorys, 'id_level2', 'level2'), [
                    'prompt'    =>  '-- Pilih --',
                ]) ?>
    </div>
    
    <?= $form->field($model, 'status',[
                            'template'  => "{label}{input}\n{hint}\n{error}"
                ])->dropDownList(Category::getStatus(), [
                    'prompt'    =>  '-- Pilih --'
                ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
