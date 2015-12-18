<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Artikel;
use backend\models\Category;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use backend\models\User;
use dosamigos\datetimepicker\DateTimePicker;
use dosamigos\selectize\SelectizeTextInput;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model backend\models\Artikel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="artikel-form">

    <?php $form = ActiveForm::begin(
            [
                        'options' => ['enctype' => 'multipart/form-data'] // important
                    ]); ?>
    
    <?=
    $form->field($model, 'categori_id', [
        'template' => "{label}{input}\n{hint}\n{error}"
    ])->dropDownList(ArrayHelper::map(Category::getCategories(Artikel::KATEGRI_BERITA), 'id_level2', 'level2'), [
        'prompt' => '-- Pilih --'
    ])
    ?>
    
    <?=
    $form->field($model, 'image1')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image1) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image1, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
    ]);
    ?>
    
    <?= $form->field($model, 'img1')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image2')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image2) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image2, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img2')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img2')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img2')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image3')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image3) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image3, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img3')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img3')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img3')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image4')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image4) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image4, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img4')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img4')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img4')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image5')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image5) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image5, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img5')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img5')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img5')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image6')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image6) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image6, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img6')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img6')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img6')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image7')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image7) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image7, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img7')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img7')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img7')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image8')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image8) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image8, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img8')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img8')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img8')->hiddenInput([])->label(false)?>
    
    <?=
    $form->field($model, 'image9')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                !$model->isNewRecord ? (!empty($model->image9) ? Html::img(\Yii::$app->jurnalrumah->lihatImageDetail($model->image9, "", $kategori = "artikel")) : NULL) : null
            ],
            'allowedFileExtensions' => ['jpg', 'png', 'jpeg'],
            'showUpload' => false,
        ],
        'pluginEvents'  =>  [
            'fileclear' =>  "function() {
                $('#".Html::getInputId($model, 'img9')."').val(1);
            }",
            'filebatchselected' =>  "function(){
                $('#".Html::getInputId($model, 'img9')."').val(0);
            }"
        ]
    ]);
    ?>
    
    <?= $form->field($model, 'img9')->hiddenInput([])->label(false)?>
    
    <?= $form->field($model, 'judul')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'deskripsi')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standard'
    ]) ?>
    <?=
    $form->field($model, 'author', [
        'template' => "{label}{input}\n{hint}\n{error}"
    ])->dropDownList(ArrayHelper::map(User::getAuthor(), 'id', 'nama_depan'), [
        'prompt' => '-- Pilih --'
    ])
    ?>

    <?= $form->field($model, 'sumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schedule_date')->widget(DateTimePicker::className(), [
        'language' => 'en',
        'size' => 'ms',
        'template' => '{input}',
        'pickButtonIcon' => 'glyphicon glyphicon-time',
//        'inline' => true,
        'clientOptions' => [
            'autoclose' => true,
//            'startView' => 1,
//            'minView' => 0,
//            'maxView' => 1,
            'format' => 'yyyy-m-dd hh:ii',
//            'linkFormat' => 'HH:ii P', // if inline = true
            // 'format' => 'HH:ii P', // if inline = false
            'todayBtn' => true
        ]
    ])
    ?>
    <?= Html::activeLabel($model, 'tag');  ?>
    <?=    SelectizeTextInput::widget([
            'model'  =>  $model->tag,
            'name'  =>  'Artikel[tag]',
            'id'    =>  'artikel-tag',
            'value' =>  $model->isNewRecord ? '' : $model->tag,
            'clientOptions' =>  [
                'plugins'   =>  ['remove_button'],
                'delimiter' =>  ',',
                'persist'   =>  false,
                'create'    =>  'function(input){
                    return {
                        value   :   input,
                        text    :   input
                    }
                }'
            ]
    ]); ?>
    <?=
    $form->field($model, 'status', [
        'template' => "{label}{input}\n{hint}\n{error}"
    ])->dropDownList(Artikel::getStatus(), [
        'prompt' => '-- Pilih --'
    ])
    ?>
    
    <?php // $form->field($model, 'video')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
