<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\components;
use Yii;
use yii\base\Widget;
use frontend\models\ArtikelSearch;

class WContentRight extends Widget{
    
    public function init() {
        parent::init();
        
    }

    public function run(){
        $model = new ArtikelSearch();
        $artikelPopular = $model->getArtikelPopular();
        
        return $this->render('_wcontentright',[
            'artikelPopular'    =>  $artikelPopular
        ]);
    }
}