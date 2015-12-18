<?php

namespace frontend\controllers;

use Yii;
use app\models\Databasemobil;
use yii\db\Query;

class JsoncController extends \yii\web\Controller {

    public function actionTotalmobil() {
        $jumlah = Databasemobil::find()->where("status=0")->count();
        $data = ["online" => $jumlah, "K_format" => Yii::$app->rajamobil->convertNumber($jumlah)];
        $path = Yii::$app->params['pathPublic'] . '/json/global/dataMobilRajamobil.json';
        $fp = fopen($path, 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
    }

    /*
     * author : mila
     * desc   : jsonc untuk model tipe
     */

    public function actionModeltipe() {
        $query = new Query;
        $query->select('m.id_merek, m.id as id_model, m.name as model, t.name as tipe, t.id as id_tipe')
                ->from('gf_mobil_model m')
                ->join('LEFT JOIN', 'gf_mobil_tipe t', 'm.id = t.id_model')
                ->orderBy('m.name  ASC');
        $data = $query->all();
        echo"<pre>";
        print_r($data);
        echo "</pre>"; #die;
        $path = Yii::$app->params['pathPublic'] . '/json/global/modeltipe.json';
        $fp = fopen($path, 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
    }

    /*
     * author : mila
     * desc   : jsonc untuk province kota
     */

    public function actionKota() {
        $query = new Query;
        $query->select('c.city_id, c.city_name, c.city_id, p.province_id, p.province_name')
                ->from('gf_city_detail c')
                ->join('INNER JOIN', 'gf_province p', 'c.province_id = p.province_id')
                ->orderBy('p.province_name ASC');
        $data = $query->all();
        echo"<pre>";
        print_r($data);
        echo "</pre>"; #die;
        $path = Yii::$app->params['pathPublic'] . '/json/global/kota.json';
        $fp = fopen($path, 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
    }

}
