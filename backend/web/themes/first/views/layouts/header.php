<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a(Yii::$app->params['appname'], Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?=
                        Html::img(\Yii::$app->jurnalrumah->lihatImageDetail(\Yii::$app->user->identity->pict, "", $kategori = "user"), [
                            'class' => 'user-image',
                            'alt' => \Yii::$app->user->identity->nama_depan
                        ])
                        ?>
                        <span class="hidden-xs"><?= \Yii::$app->user->identity->nama_depan ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?=
                            Html::img(\Yii::$app->jurnalrumah->lihatImageDetail(\Yii::$app->user->identity->pict, "", $kategori = "user"), [
                                'class' => 'img-circle',
                                'alt' => \Yii::$app->user->identity->nama_depan
                            ])
                            ?>
                            <p>
                                <?= \Yii::$app->user->identity->nama_depan ?>
                                <small>Member sejak <?= \Yii::$app->jurnalrumah->convertToTanggal(\Yii::$app->user->identity->date_create, $type= 4) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('Profile', ['/user/update','id'  => \Yii::$app->user->identity->id], [
                                        'class' =>  'btn btn-default btn-flat'
                                ])?>
                                <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>
    </nav>
</header>