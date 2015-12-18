<?php

namespace frontend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use frontend\models\ArtikelSearch;
use app\components\ParentController;

class BeritaController extends ParentController {

//    public function actionIndex() {
//        $per_page = \Yii::$app->params['limitArtikelPerPage'];
//        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
//        $per_page = (isset($_GET['per-page']) ? $_GET['per-page'] : $per_page);
//        $pagesize = (isset($_GET['pagesize']) ? $_GET['pagesize'] : 0);
//
//        //SLIDER
//        $sliderheadline = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', array('headline' => 'true', 'limit' => 5));
//
//        //SEO
//        $this->view->title = 'Berita Otomotif Terupdate';
//        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Artikel, berita dan Tips seputar mobil, berita otomotif terbaru'], 'meta-description');
//        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'artikel mobil, berita otomotif, tips kendaraan, berita mobil, tips mobil, jurnalrumah, mobil bekas, jual beli mobil, harga mobil, mobil bekas, mobil baru, bursa mobil, berita mobil, showroom mobil, aksesoris mobil, modifikasi mobil'], 'meta-keywords');
//        $this->view->registerLinkTag(['title' => 'Artikel JurnalRumah', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.jurnalrumah.com/berita']);
//        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'property-fb:app_id');
//        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
//        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'JurnalRumah.com'], 'meta-publisher');
//        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
//        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'JurnalRumah : Jual Beli Rumah Baru dan Bekas'], 'meta-distribution');
//        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
//        $kategori_name = "Berita";
//        $paramArtikel = [
//            'start' => $pagesize,
//            'limit' => $per_page,
//        ];
//
//        $artikel = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
//
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => (isset($artikel['docs']) ? $artikel['docs'] : $artikel),
//            'pagination' => [
//                'pageSize' => \Yii::$app->params['limitArtikelPerPage'],
//            ],
//        ]);
//        
//        
//        return $this->render('index', [
//                    'sliderheadline' => $sliderheadline,
//                    'artikel' => $artikel,
//                    'dataProvider' => $dataProvider,
//                    'kategori_name' => $kategori_name
//        ]);
//    }

    public function actionKategori() {
//         var_dump($_GET);die;
        $queryString = isset($_GET['kat']) ? $_GET['kat'] : '';
        $per_page = \Yii::$app->params['pageSizeListview'];
        
        $per_page = (isset($_GET['per-page']) ? $_GET['per-page'] : $per_page);
        $pagesize = (isset($_GET['pagesize']) ? $_GET['pagesize'] : 0); // 5 = jumlah slider headeline
        
        $params = [
            'start' => $pagesize,
            'limit' => $per_page,
            'kat' =>  $queryString
        ];
        
        $searchArtikel = new ArtikelSearch();
        $searchArtikel = $searchArtikel->searchArtikel($params);
        
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => (isset($searchArtikel['docs']) ? $searchArtikel['docs'] : $searchArtikel),
            'pagination' => [
                'pageSize' => \Yii::$app->params['pageSizeListview'],
            ],
        ]);
     
        //SEO
        $this->view->title = 'Berita '.  ucwords($queryString).' Terupdate Halaman '.$per_page;
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Berita, berita terkait rumah, berita rumah terbaru, berita kategori '.  ucwords($queryString).' halaman '.$per_page], 'meta-description');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'berita rumah, berita perumahan, tips rumah, tips perumahan, jurnalrumah, rumahbaru, rumahbekas, carirumah bekas, carirumahbaru, carirumahmurah, jualrumah bekas, jualrumah baru, jualrumahmurah, rumah tanpa riba'], 'meta-keywords');
        $this->view->registerLinkTag(['title' => 'Artikel JurnalRumah', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.jurnalrumah.com/berita']);
        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'property-fb:app_id');
        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'JurnalRumah.com'], 'meta-publisher');
        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'JurnalRumah : Jual Rumah Baru dan Bekas'], 'meta-distribution');
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => 'http://www.jurnalrumah.com']);
        $this->view->registerLinkTag(['rel' => 'publisher', 'href' => 'https://plus.google.com/115358618390268779655']);

        return $this->render('cariberita',[
            'dataProvider'  => $dataProvider,
            'cariberita'  =>  $queryString,
//            'results' =>  (isset($searchArtikel['docs']) && !empty($searchArtikel['docs'])) ? $searchArtikel['docs'] : '',
            'count' =>  isset($searchArtikel['numFound']) ? (isset($searchArtikel['numFound'][0]) ? $searchArtikel['numFound'][0] : 0) : 0
        ]);
    }

    public function actionTag() {
        $queryString = isset($_GET['tagberita']) ? $_GET['tagberita'] : '';
        $per_page = \Yii::$app->params['pageSizeListview'];
        
        $per_page = (isset($_GET['per-page']) ? $_GET['per-page'] : $per_page);
        $pagesize = (isset($_GET['pagesize']) ? $_GET['pagesize'] : 0); // 5 = jumlah slider headeline
        
        $params = [
            'start' => $pagesize,
            'limit' => $per_page,
            'tagberita' =>  $queryString
        ];
        
        $searchArtikel = new ArtikelSearch();
        $searchArtikel = $searchArtikel->searchArtikel($params);
        
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => (isset($searchArtikel['docs']) ? $searchArtikel['docs'] : $searchArtikel),
            'pagination' => [
                'pageSize' => \Yii::$app->params['pageSizeListview'],
            ],
        ]);
     
        //SEO
        $this->view->title = 'Berita '.  ucwords($queryString).' Terupdate Halaman '.$per_page;
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Berita, berita terkait rumah, berita rumah terbaru, berita kategori '.  ucwords($queryString).' halaman '.$per_page], 'meta-description');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'berita rumah, berita perumahan, tips rumah, tips perumahan, jurnalrumah, rumahbaru, rumahbekas, carirumah bekas, carirumahbaru, carirumahmurah, jualrumah bekas, jualrumah baru, jualrumahmurah, rumah tanpa riba'], 'meta-keywords');
        $this->view->registerLinkTag(['title' => 'Artikel JurnalRumah', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.jurnalrumah.com/berita']);
        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'property-fb:app_id');
        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'JurnalRumah.com'], 'meta-publisher');
        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'JurnalRumah : Jual Rumah Baru dan Bekas'], 'meta-distribution');
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => 'http://www.jurnalrumah.com']);
        $this->view->registerLinkTag(['rel' => 'publisher', 'href' => 'https://plus.google.com/115358618390268779655']);

        return $this->render('cariberita',[
            'dataProvider'  => $dataProvider,
            'cariberita'  =>  $queryString,
//            'results' =>  (isset($searchArtikel['docs']) && !empty($searchArtikel['docs'])) ? $searchArtikel['docs'] : '',
            'count' =>  isset($searchArtikel['numFound']) ? (isset($searchArtikel['numFound'][0]) ? $searchArtikel['numFound'][0] : 0) : 0
        ]);
    }

    public function actionDetail() {
        
        $artikel = new ArtikelSearch;
        
        $detail = $artikel->getArtikelById($params = [
            'id'    =>  $_GET['id']
        ]);
        
        $detail = isset($detail['docs']) ? $detail['docs'] : $detail;
        
        // artikel terkait
        $per_page = \Yii::$app->params['pageSizeListview'];
        $per_page = (isset($_GET['per-page']) ? $_GET['per-page'] : $per_page);
        $pagesize = (isset($_GET['pagesize']) ? $_GET['pagesize'] : 0); // 5 = jumlah slider headeline

        $params = [
            'start' => $pagesize,
            'limit' => $per_page,
            'tagterkait'    =>  $detail['tag'],
            'idExcept'    =>  $detail['id']
        ];
        
        $artikelLainnya = $artikel->getArtikelLainnya($params = $params);
//        if(empty($artikelLainnya['docs'])){
//            $params = [
//                'start' => $pagesize,
//                'limit' => $per_page,
//                'kat'    =>  $detail['categori_name'],
//                'idExcept'    =>  $detail['id']
//            ];
//            $artikelLainnya = $artikel->searchArtikel($params = $params);
//        }
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => (isset($artikelLainnya['docs']) ? $artikelLainnya['docs'] : $artikelLainnya),
            'pagination' => [
                'pageSize' => \Yii::$app->params['pageSizeListview'],
            ],
        ]);
        

        // end artikel terkait 
        // register SEO
        $detail = (isset($detail[0]) ? $detail[0] : $detail);
        $count_summary = strlen($detail['summary']);
        $this->view->title = $detail['judul'];
        if ($count_summary > 155)
            $description = strip_tags(substr($detail['summary'], 0, 152)) . '...';
        else
            $description = strip_tags($detail['summary']);
        
        $penulis =  ucwords($detail["author_name"]);

        $this->view->registerMetaTag(['name' => 'description', 'content' => $description], 'meta-description');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $detail['tag']], 'meta-keywords');
        $this->view->registerLinkTag(['title' => $detail['judul']]);
        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'property-fb:app_id');
        $this->view->registerMetaTag(['name' => 'author', 'content' => $penulis], 'meta-author');
        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'JurnalRumah.com'], 'meta-publisher');
        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'JurnalRumah : Jual Beli Rumah Baru dan Bekas'], 'meta-distribution');
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => \Yii::$app->urlManager->createAbsoluteUrl(\Yii::$app->request->url)]);

        // register FB
        $this->view->registerMetaTag(['name' => 'og:title', 'content' => $detail['judul']]);
        $this->view->registerMetaTag(['name' => 'og:image', 'content' => Yii::$app->jurnalrumah->lihatImageDetail($detail['image1'], "", "artikel")]);
        $this->view->registerMetaTag(['name' => 'og:site_name', 'content' => 'JurnalRumah.com']);
        $this->view->registerMetaTag(['name' => 'og:url', 'content' => \Yii::$app->urlManager->createAbsoluteUrl(\Yii::$app->request->url)]);
        $this->view->registerMetaTag(['name' => 'og:description', 'content' => $description]);
        $this->view->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
        
        return $this->render('detail', [
                    'detail' => (isset($detail[0]) ? $detail[0] : $detail),
                    'dataProvider' =>  $dataProvider
        ]);
    }
    
    public function actionCariberita(){
        
        $queryString = isset($_GET['query']) ? $_GET['query'] : '';
        $per_page = \Yii::$app->params['pageSizeListview'];
        
        $per_page = (isset($_GET['per-page']) ? $_GET['per-page'] : $per_page);
        $pagesize = (isset($_GET['pagesize']) ? $_GET['pagesize'] : 0); // 5 = jumlah slider headeline
        
        $params = [
            'start' => $pagesize,
            'limit' => $per_page,
            'query' =>  $queryString
        ];
        
        $searchArtikel = new ArtikelSearch();
        $searchArtikel = $searchArtikel->searchArtikel($params);
        
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => (isset($searchArtikel['docs']) ? $searchArtikel['docs'] : $searchArtikel),
            'pagination' => [
                'pageSize' => \Yii::$app->params['pageSizeListview'],
            ],
        ]);
        
        //SEO
        $this->view->title = 'Berita '.  ucwords($queryString).' Terupdate Halaman '.$per_page;
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Berita, berita terkait rumah, berita rumah terbaru, berita kategori '.  ucwords($queryString).' halaman '.$per_page], 'meta-description');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'berita rumah, berita perumahan, tips rumah, tips perumahan, jurnalrumah, rumahbaru, rumahbekas, carirumah bekas, carirumahbaru, carirumahmurah, jualrumah bekas, jualrumah baru, jualrumahmurah, rumah tanpa riba'], 'meta-keywords');
        $this->view->registerLinkTag(['title' => 'Artikel JurnalRumah', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.jurnalrumah.com/berita']);
        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'property-fb:app_id');
        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'JurnalRumah.com'], 'meta-publisher');
        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'JurnalRumah : Jurnal Rumah Baru dan Bekas'], 'meta-distribution');
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => 'http://www.jurnalrumah.com']);
        $this->view->registerLinkTag(['rel' => 'publisher', 'href' => 'https://plus.google.com/115358618390268779655']);
        
        return $this->render('cariberita',[
            'dataProvider'  => $dataProvider,
            'cariberita'  =>  $queryString,
//            'results' =>  (isset($searchArtikel['docs']) && !empty($searchArtikel['docs'])) ? $searchArtikel['docs'] : '',
            'count' =>  isset($searchArtikel['numFound']) ? (isset($searchArtikel['numFound'][0]) ? $searchArtikel['numFound'][0] : 0) : 0
        ]);
    }

}
