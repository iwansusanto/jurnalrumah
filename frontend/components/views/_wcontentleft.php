<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>
<div class="header-left-cat">
    <span class="header-right-thin">Rumah </span><span class="header-right-bold">DIJUAL</span>
</div>
<ul class="list-rumah-dijual">
    <li>
        <div class="img-rumah-dijual-l">
            <?=
            Html::img($this->theme->getUrl('images/komponen/rumah1.jpg'), [
                'width' =>  138,
                'height'    =>  101
            ])
        ?>
        </div>
        <div class="judul-rumah-dijual-l">
            Dijual Rumah Di Depok<br> Rp. 100.0000,-
        </div>
    </li>
    <li>
        <div class="img-rumah-dijual-l">
            <?=
            Html::img($this->theme->getUrl('images/komponen/rumah2.jpg'), [
                'width' =>  138,
                'height'    =>  101
            ])
        ?>
        </div>
        <div class="judul-rumah-dijual-l">
            Dijual Rumah Di Depok<br> Rp. 140.0000,-
        </div>
    </li>
    <li>
        <div class="img-rumah-dijual-l">
            <?=
            Html::img($this->theme->getUrl('images/komponen/rumah3.jpg'), [
                'width' =>  138,
                'height'    =>  101
            ])
        ?>
        </div>
        <div class="judul-rumah-dijual-l">
            Dijual Rumah Di Depok<br> Rp. 180.0000,-
        </div>
    </li>
    <li>
        <div class="img-rumah-dijual-l">
            <?=
            Html::img($this->theme->getUrl('images/komponen/rumah4.jpg'), [
                'width' =>  138,
                'height'    =>  101
            ])
        ?>
        </div>
        <div class="judul-rumah-dijual-l">
            Dijual Rumah Di Depok<br> Rp. 120.0000,-
        </div>
    </li>
    <li>
        <div class="img-rumah-dijual-l">
            <?=
            Html::img($this->theme->getUrl('images/komponen/rumah5.jpg'), [
                'width' =>  138,
                'height'    =>  101
            ])
        ?>
        </div>
        <div class="judul-rumah-dijual-l">
            Dijual Rumah Di Depok<br> Rp. 110.0000,-
        </div>
    </li>
</ul>

