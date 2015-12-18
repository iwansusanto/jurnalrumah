<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\components;
use Yii;
use yii\base\Widget;
use frontend\models\Artikel;

class WContentLeft extends Widget{
    
    public function init() {
        parent::init();
        
    }

    public function run(){
        $model = new Artikel();
        
        return $this->render('_wcontentleft',[
            'model'    =>  $model
        ]);
    }
}