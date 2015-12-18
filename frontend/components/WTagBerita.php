<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\components;
use Yii;
use yii\base\Widget;
use frontend\models\TagSearch;

class WTagBerita extends Widget{
    
    public function init() {
        parent::init();
        
    }

    public function run(){
        $model = new TagSearch();
        $artikelTag = $model->getTagPopular();
//        print_r($artikelTag);
        
        return $this->render('_tagberita',[
            'artikelTag'    =>  $artikelTag
        ]);
    }
}