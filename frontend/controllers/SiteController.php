<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\ParentController;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use frontend\models\ArtikelSearch;

/**
 * Site controller
 */
class SiteController extends ParentController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
//            'pageCache' =>  [
//                'class' =>  'yii\filters\PageCache',
//                'only'  =>  ['index'],
//                'duration'  =>  \Yii::$app->params['cache']['homePage']['expire']
//            ],
//            [
//               'class' => 'yii\filters\HttpCache',
//                'only' => ['index'],
//                'etagSeed' => function ($action, $params) {
////                    error_log(serialize(Url::current())."\n\n" , 3, 'e:/kota.log');
//                    return serialize(Url::current());
//                },
//                'cacheControlHeader' => 'public, max-age=3600',
////                'enabled' => true
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    

//    public function actionCariBerita() {
//        $cariberita = isset($_GET['keyberita']) ? $_GET['keyberita'] : '';
//        #echo 'Cari : ';print_r($cariberita);die;
//        $jumlah_berita = Yii::$app->params['limitArtikelPerPage'];
//        $page = isset($_GET['page']) ? ($_GET['page'] + 1) : 2;
//        $start = ($page - 2) * $jumlah_berita;
//        $param = array(); // untuk menampung kondisi request ke API
//        $params_url = array();
//        $tagnya = "";
//        if (isset($cariberita) && $cariberita != ""):
//            $flagTag = $cariberita;
//            $params_url['tag'] = $cariberita;
//            $param['tag'] = urlencode($cariberita);
//            $tagnya = urlencode($cariberita);
//        endif;
//        $param['start'] = $start;
//        $param['limit'] = $jumlah_berita;
//        $params_url['page'] = $page;
//        //SIDEBAR
//        $berita_path = Yii::$app->params['pathPublic'] . "/json/global/homeiklan.json";
//        $berita_content = file_get_contents($berita_path);
//        $berita = json_decode($berita_content, true);
//
//        //SEO
//        #$canonical = \Yii::$app->urlManager->createAbsoluteUrl('tag/' . (str_replace(' ', '-', $tag)) . (($page > 0) ? '-page-' . $page : '') . '.htm');
//        $this->view->title = 'Pencarian Artikel' . (!empty($cariberita) ? ' dengan Keyword ' . $cariberita : '') . (($page > 0) ? ' Halaman ' . $page : '');
//        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Pencarian Artikel : ' . strtolower($cariberita) . ', berita dan Tips seputar mobil dan juga otomotif terbaru, indonesia dan mancanegara' . (($page > 0) ? ', halaman ' . $page : '')], 'meta-description');
//        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'artikel mobil, berita otomotif, tips kendaraan, berita mobil, tips mobil, rajamobil, mobil bekas, jual beli mobil, harga mobil, mobil bekas, mobil baru, bursa mobil, berita mobil, showroom mobil, aksesoris mobil, modifikasi mobil'], 'meta-keywords');
//        $this->view->registerLinkTag(['title' => 'Artikel RajaMobil Mobile Site', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.rajamobil.com/berita']);
//        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'property-fb:app_id');
//        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
//        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'RajaMobil.com'], 'meta-publisher');
//        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
//        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'RajaMobil : Jual Beli Mobil Baru dan Bekas Harga Murah'], 'meta-distribution');
//        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
//        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => '']);
//        $this->view->registerLinkTag(['rel' => 'publisher', 'href' => 'https://plus.google.com/113698645893279863101']);
//
//        $artikel = Yii::$app->rajamobil->curlApi($methode = "GET", $url = "artikel/search", $params = $param);
//        $sliderheadline = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', array('tag' => $tagnya, 'headline' => 'true', 'start' => 0, 'limit' => 5));
//        #var_dump($sliderheadline);die;
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => (isset($artikel['docs']) ? $artikel['docs'] : $artikel),
//            'pagination' => [
//                'pageSize' => \Yii::$app->params['limitArtikelPerPage'],
//            ],
//        ]);
//        return $this->render('/berita/index', array(
//                    'sliderheadline' => $sliderheadline,
//                    'dataProvider' => $dataProvider,
//                    'cariberita' => $cariberita,
//                    'page' => $page,
//                    'jumlah_berita' => $jumlah_berita,
//                    'param' => $param,
//                    'params_url' => $params_url
//        ));
//        #\Yii::$app->end();
//    }


    

    public function actionIndex() {
        $per_page = \Yii::$app->params['pageSizeListview'];
        
        $per_page = (isset($_GET['per-page']) ? $_GET['per-page'] : $per_page);
        $pagesize = (isset($_GET['pagesize']) ? $_GET['pagesize'] + 5 : 5); // 5 = jumlah slider headeline
        
        $artikel = new ArtikelSearch;
        $artikelTerupdate = $artikel->getArtikelTerupdate();

        $params = [
            'start' => $pagesize,
            'limit' => $per_page,
        ];
        
        $artikelLainnya = $artikel->getArtikelLainnya($params = $params);
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => (isset($artikelLainnya['docs']) ? $artikelLainnya['docs'] : $artikelLainnya),
            'pagination' => [
                'pageSize' => \Yii::$app->params['pageSizeListview'],
            ],
        ]);
        
        $this->view->title = 'Jurnal Jual Beli Rumah Baru dan Bekas - JurnalRumah';
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Dapatkan informasi terkait rumah baru dan bekas'], 'meta-description');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'berita rumah, berita perumahan, tips rumah, tips perumahan, jurnalrumah, rumahbaru, rumahbekas, carirumah bekas, carirumahbaru, carirumahmurah, jualrumah bekas, jualrumah baru, jualrumahmurah, rumah tanpa riba'], 'meta-keywords');
        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'meta-property');
        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'JurnalRumah.com'], 'meta-publisher');
        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'JurnalRumah : Jurnal Rumah Baru dan Bekas'], 'meta-distribution');
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
        $this->view->registerLinkTag(['title' => 'JurnalRumah Mobile Site', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.jurnalrumah.com']);
        $this->view->registerLinkTag(['title' => 'Canonical', 'rel' => 'canonical', 'href' => 'http://www.jurnalrumah.com']);
        $this->view->registerLinkTag(['title' => 'Publisher', 'rel' => 'publisher', 'href' => 'https://plus.google.com/115358618390268779655']);



        return $this->render('index', [
                    'artikelTerupdate' => $artikelTerupdate,
                    'dataProvider' =>  $dataProvider
        ]);
//        return $this->render('index1');
    }

    public function actionHubungikami(){
        die('hubungikami');
    }
    
//    public function actionContact() {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//            } else {
//                Yii::$app->session->setFlash('error', 'There was an error sending email.');
//            }
//
//            return $this->refresh();
//        } else {
//            return $this->render('contact', [
//                        'model' => $model,
//            ]);
//        }
//    }

//    public function actionAbout() {
//        return $this->render('about');
//    }
    
//    public function actionTentangkami(){
//        $this->view->title = 'Tentang RajaMobil.com';
//        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Tentang RajaMobil.com, Portal Otomotif Indonesia, Seputar otomotif, Jual Mobil dan Terpercaya'], 'meta-description');
//        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'rajamobil, mobil bekas, jual beli mobil, harga mobil, mobil bekas, mobil baru, bursa mobil, berita mobil, showroom mobil, aksesoris mobil, modifikasi mobil'], 'meta-keywords');
//        $this->view->registerMetaTag(['name' => 'author', 'content' => 'admin'], 'meta-author');
//        $this->view->registerMetaTag(['property' => 'fb:app_id', 'content' => '181411581975733'], 'meta-property');
//        $this->view->registerMetaTag(['name' => 'publisher', 'content' => 'RajaMobil.com'], 'meta-publisher');
//        $this->view->registerMetaTag(['name' => 'content-language', 'content' => 'Indonesia'], 'meta-content-language');
//        $this->view->registerMetaTag(['name' => 'distribution', 'content' => 'RajaMobil : Jual Beli Mobil Baru dan Bekas Harga Murah'], 'meta-distribution');
//        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow'], 'meta-robots');
//        $this->view->registerLinkTag(['title' => 'RajaMobil Mobile Site', 'rel' => 'alternate', 'media' => 'handheld', 'href' => 'http://m.rajamobil.com']);
//        $this->view->registerLinkTag(['title' => 'Canonical', 'rel' => 'canonical', 'href' => 'http://www.rajamobil.com']);
//        $this->view->registerLinkTag(['title' => 'Publisher', 'rel' => 'publisher', 'href' => 'https://plus.google.com/115358618390268779655']);
//
//        return $this->render('tentangkami');
//    }
}
