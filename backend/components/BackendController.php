<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components;
use yii\web\Controller;

class BackendController extends Controller{
    public function init() {
        parent::init();
    }
    
    public function beforeAction($action) {
        if(parent::beforeAction($action)){
            if (\Yii::$app->user->isGuest && $this->action->id !== 'login') {
//                \Yii::$app->user->loginUrl = ['site/login'];
                \Yii::$app->user->loginRequired();
                return true;
            }
            return true;
        }
    }
    
    
}