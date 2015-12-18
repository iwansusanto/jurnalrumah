<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;
use yii\web\Controller;

class ParentController extends Controller{
    
    public function init() {
        parent::init();
    }
    
    public static function esitime( $ptime ){
        $estimate_time = time() - $ptime;

        if( $estimate_time < 1 )
        {
            return 'less than 1 second ago';
        }

        $condition = array( 
                    12 * 30 * 24 * 60 * 60  =>  'tahun',
                    30 * 24 * 60 * 60       =>  'bulan',
                    24 * 60 * 60            =>  'hari',
                    60 * 60                 =>  'jam',
                    60                      =>  'menit',
                    1                       =>  'detik'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $estimate_time / $secs;

            if( $d >= 1 )
            {
                $r = round( $d );
                // return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' lalu';
                return $r . ' ' . $str . ' lalu';
            }
        }
    }
    
}