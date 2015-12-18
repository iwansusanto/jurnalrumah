<?php
use yii\bootstrap\Nav;
use app\widgets\Menu;

//$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower') . '/admin-lte/dist';
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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
        <?=        Menu::widget([
                'options'=>['class'=>'sidebar-menu'],
                'labelTemplate' => '<a href="#">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                'submenuTemplate'=>"\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                'activateParents'=>true,
                'items'=>[
                    [
                        'label'=>'Gii',
                        'icon'=>'<i class="fa fa-cogs"></i>',
                        'url'=>['/gii'],
                        
                    ],
                    [
                        'label'=>'Custom Web',
                        'icon'=>'<i class="fa fa-user"></i>',
                        'url'=>'#',
                        'items' =>  [
                            [
                                'label'    =>  'Menu Utama',
                                'icon'=>'<i class="fa fa-circle-o"></i>',
                                'url'   =>  ['/menuutama'],
                            ],
                            [
                                'label' =>  'Warna',
                                'icon'=>'<i class="fa fa-circle-o"></i>',
                                'url'   =>  ['warna'],
                            ]
                        ]
                        
                    ],
                    [
                        'label' =>  'Setting',
                        'icon'  =>  '<i class="fa fa-gear"></i>',
                        'url'   =>  '#',
                        'items' =>  [
                            [
                                'label' =>  'Category',
                                'icon'  =>  '<i class="fa fa-archive"></i>',
                                'url'   =>  ['/category']
                            ],
                            [
                                'label' =>  'Fitur',
                                'icon'  =>  '<i class="fa fa-briefcase"></i>',
                                'url'   =>  ['/fitur']
                            ],
                            [
                                'label' =>  'Template',
                                'icon'  =>  '<i class="fa fa-suitcase"></i>',
                                'url'   =>  ['/template']
                            ],
                            [
                                'label' =>  'Portfolio',
                                'icon'  =>  '<i class="fa fa-book"></i>',
                                'url'   =>  ['/portfolio']
                            ]
                        ]
                    ]
                ]
            ]) ?>
    </section>

</aside>