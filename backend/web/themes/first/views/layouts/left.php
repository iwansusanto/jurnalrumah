<?php

use yii\bootstrap\Nav;
use app\widgets\Menu;
use yii\helpers\Html;

//$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower') . '/admin-lte/dist';
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?=
                Html::img(\Yii::$app->jurnalrumah->lihatImageDetail(\Yii::$app->user->identity->pict, "", $kategori = "user"), [
                    'class' => 'img-circle',
                    'alt' => \Yii::$app->user->identity->nama_depan
                ])
                ?>
            </div>
            <div class="pull-left info">
                <p><?= \Yii::$app->user->identity->nama_depan ?></p>
                <?=
                Html::a('<i class="fa fa-circle text-success"></i> Online', '#', [
                ])
                ?>
            </div>
        </div>

        <!-- Search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- End search form -->

        <!-- Menu -->
        <?=
        Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'labelTemplate' => '<a href="#">{icon}<span>{label}</span>{right-icon}{badge}</a>',
            'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
            'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
            'activateParents' => true,
            'items' => [
                [
                    'label' => 'Gii',
                    'icon' => '<i class="fa fa-cogs"></i>',
                    'url' => ['/gii'],
                    'visible'   =>  (\Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())[\Yii::$app->user->identity->role]->name == 'Superadmin')
                ],
                [
                    'label' => 'Permission',
                    'icon' => '<i class="fa fa-tasks"></i>',
                    'url' => ['/admin'],
                    'visible'   =>  (\Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())[\Yii::$app->user->identity->role]->name == 'Superadmin')
                ],
                [
                    'label' => 'Artikel',
                    'icon' => '<i class="fa fa-newspaper-o"></i>',
                    'url' => ['/artikel'],
                ],
                [
                    'label' => 'Setting',
                    'icon' => '<i class="fa fa-gear"></i>',
                    'url' => '#',
                    'visible'   =>  (\Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())[\Yii::$app->user->identity->role]->name == 'Superadmin' || \Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())[\Yii::$app->user->identity->role]->name == 'admin'),
                    'items' => [
                        [
                            'label' => 'User',
                            'icon' => '<i class="fa fa-user"></i>',
                            'url' => ['/user'],
//                            'visible'   =>  (\Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())[\Yii::$app->user->identity->role]->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())[\Yii::$app->user->identity->role]->name == 'admin')
                        ],
                        [
                            'label' => 'Kategori',
                            'icon' => '<i class="fa fa-bars"></i>',
                            'url' => ['/category'],
//                            'visible'   =>  (Yii::$app->authManager->getRole('Bukan Superman')->name) == Yii::$app->user->identity->role
                        ]
                    ]
                ]
            ]
        ])
        ?>
    </section>

</aside>