<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <h1><?= Html::encode($this->title) ?></h1>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>    
            <div class="form-group has-feedback">
                <?= $form->field($model, 'username',
                        ['template' =>  "{input}\n<span class='glyphicon glyphicon-envelope form-control-feedback'></span>\n{hint}\n{error}"])->textInput([
                        'placeholder'   =>  'Email']) ?>
                
            </div>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'password',
                        ['template' =>  "{input}\n<span class='glyphicon glyphicon-lock form-control-feedback'></span>\n{hint}\n{error}"])->passwordInput([
                            'placeholder'   =>  'Password'
                        ]) ?>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe',
                            ['template' =>  "<div class='checkbox icheck'>{input}\n{label}</div>"])->checkbox([
                        
                    ], false) ?>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div><!-- /.col -->
            </div>
        <?php ActiveForm::end(); ?>
        <!--</form>-->

        Lupa password ? Klik di <a href="#">sini</a>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->


<?php
$this->registerJs(
    '$(function () {
        $("input").iCheck({
          checkboxClass: "icheckbox_square-blue",
          radioClass: "iradio_square-blue",
          increaseArea: "20%" // optional
        });
      });'
, View::POS_READY);

?>