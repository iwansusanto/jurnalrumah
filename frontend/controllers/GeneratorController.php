<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use DOMDocument;
use DOMElement;
use DOMText;
use yii\base\Arrayable;
use yii\base\Component;
use yii\helpers\StringHelper;
use app\components\ParentController;
use app\models\MobilMerek;

class GeneratorController extends \app\components\ParentController {

    public function actionIndex() {
        echo 'welcome generator';
        return false;
    }

    public function actionCompress($text) { // 
        $re = '%# Collapse ws everywhere but in blacklisted elements.
(?> # Match all whitespans other than single space.
[^\S ]\s* # Either one [\t\r\n\f\v] and zero or more ws,
| \s{2,} # or two or more consecutive-any-whitespace.
) # Note: The remaining regex consumes no text at all...
(?= # Ensure we are not in a blacklist tag.
(?: # Begin (unnecessary) group.
(?: # Zero or more of...
[^<]++ # Either one or more non-"<"
| < # or a < starting a non-blacklist tag.
(?!/?(?:textarea|pre)\b)
)*+ # (This could be "unroll-the-loop"ified.)
) # End (unnecessary) group.
(?: # Begin alternation group.
< # Either a blacklist start tag.
(?>textarea|pre)\b
| \z # or end of file.
) # End alternation group.
) # If we made it here, we are not in a blacklist tag.
%ix';
        $text = preg_replace($re, " ", $text);
        return $text;
    }

    public function actionHeader() {

        $header = $this->renderFile(\Yii::getAlias('@rmperjuangan') . '/views/layouts/header.php');
        $header = $this->actionCompress($header);
        $generate = file_put_contents(\Yii::getAlias('@rmperjuangan') . '/views/layouts/header_generated.html', $header);
        if ($generate) {
            echo 'file header successfully generated';
        }
    }

    public function actionFooter() {

        $footer = $this->renderFile(\Yii::getAlias('@rmperjuangan') . '/views/layouts/footer.php');
        $footer = $this->actionCompress($footer);
        $generate = file_put_contents(\Yii::getAlias('@rmperjuangan') . '/views/layouts/footer_generated.html', $footer);
        if ($generate) {
            echo 'file footer successfully generated';
        }
    }

    public function actionMerek() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $data = MobilMerek::getAll();

        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);
        $kondisi = array('baru', 'bekas');
        foreach ($data as $value) {
            foreach ($kondisi as $kond) {
                $linknya = 'http://www.rajamobil.com/' . 'jual/mobil/' . $kond . '/' . urlencode(strtolower($value['name']));
                $item = $xml->createElement('item');

                $title = $xml->createElement("title");
                $titleText = $xml->createTextNode('Jual Mobil ' . ucwords($kond) . ' ' . ucwords(strtolower($value['name'])));
                $title->appendChild($titleText);

                $link = $xml->createElement("link");
                $linkText = $xml->createTextNode($linknya);
                $link->appendChild($linkText);

                $description = $xml->createElement('description');
                $descriptiontext = $xml->createTextNode('Bursa Jual Beli Mobil ' . ucwords($kond) . ' ' . ucwords(strtolower($value['name'])));
                $description->appendChild($descriptiontext);

                $guid = $xml->createElement('guid');
                $guidtext = $xml->createTextNode($linknya);
                $guid->appendChild($guidtext);

                $item->appendChild($title);
                $item->appendChild($link);
                $item->appendChild($description);
                $item->appendChild($guid);
                $ad->appendChild($item);
                $parentnode->appendChild($ad);
            }
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/merek.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionModel() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $data = MobilMerek::getAll();
        $data2 = file_get_contents(Yii::$app->params['pathPublic'] . '/json/global/model.json');
        $data2 = json_decode($data2);
        $data2 = json_decode(json_encode($data2), true);
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);
        $kondisi = array('baru', 'bekas');
        foreach ($data as $value){
            foreach ($data2 as $key => $model){
                foreach ($kondisi as $kond) {
                    if ($value['id'] == $model['id_merek']) {
//                        var_dump($models);die;
                        $linknya = 'http://www.rajamobil.com/' . 'jual/mobil/' . $kond . '/' . urlencode(strtolower($value['name'])). '/' . urlencode(strtolower($model['name']));
                        $item = $xml->createElement('item');

                        $title = $xml->createElement("title");
                        $titleText = $xml->createTextNode('Jual Mobil ' . ucwords($kond) . ' ' . ucwords(strtolower($value['name'])) . ' ' . ucwords(strtolower($model['name'])));
                        $title->appendChild($titleText);

                        $link = $xml->createElement("link");
                        $linkText = $xml->createTextNode($linknya);
                        $link->appendChild($linkText);

                        $description = $xml->createElement('description');
                        $descriptiontext = $xml->createTextNode('Bursa Jual Beli Mobil ' . ucwords($kond) . ' ' . ucwords(strtolower($value['name'])) . ' ' . ucwords(strtolower($model['name'])));
                        $description->appendChild($descriptiontext);

                        $guid = $xml->createElement('guid');
                        $guidtext = $xml->createTextNode($linknya);
                        $guid->appendChild($guidtext);

                        $item->appendChild($title);
                        $item->appendChild($link);
                        $item->appendChild($description);
                        $item->appendChild($guid);
                        $ad->appendChild($item);
                        $parentnode->appendChild($ad);
                    }
                }
            }
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/merek.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionShowroom() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramShowroom = [
            'tipepenjual' => 0,
            'limit' => 6000,
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'showroom/search', $param = $paramShowroom);
        $data = isset($data['docs']) ? $data['docs'] : $data;
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            $date_created = isset($value['date_created']) && !empty($value['date_created']) ? $value['date_created'] : '';
            $city_name = isset($value['city_name']) && !empty($value['city_name']) ? $value['city_name'] : '';
            $slug = (isset($value['slug']) && $value['slug'] != "" ? Yii::$app->rajamobil->slug(strtolower($value['slug'])) : Yii::$app->rajamobil->slug(strtolower($value['fullname'])));
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['showroom/detail/', 'id' => $value['id'], 'slug' => $slug]);
//            var_dump($linknya);die;
            $linknya = 'http://www.rajamobil.com/' . 'showroom/detail/' . $value['id'] . '-' . $slug . '.htm';
            $datenya = date('Y/m/d', strtotime(substr($date_created, 0, 10)));
            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode('Showroom ' . ucwords(strtolower($value['fullname'])) . ' di Kota ' . $city_name);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode('Bursa Jual Beli Mobil Bekas dan Baru');
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/showroom.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionBeritamobil() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'limit' => 50,
            'kategoriId' => 5
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/artikelmobil.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionTestdrive() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'limit' => 50,
            'kategoriId' => 13
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/testdrive.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionKomunitas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'limit' => 50,
            'kategoriId' => 18
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/komunitas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionBengkelservis() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'limit' => 50,
            'kategoriId' => 21
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/artikel_bengkel.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionModifikasi() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'limit' => 50,
            'kategoriId' => 20
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/artikel_modifikasi.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionVideo() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'limit' => 50,
            'kategoriId' => 22
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/artikel_video.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionIndeks() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'schedule_date' => 'true'
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/artikel_indeksnya.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionArtikelmobilfulldesc() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'schedule_date' => 'true'
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'artikel/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if (isset($value["scheduled_date"]) && $value["scheduled_date"] != '0000-00-00 00:00:00') {
                $date = $value["scheduled_date"];
                //    echo 'nah';
            } else {
                $date = $value["created"];
                //    echo 'nih';
            }
            $time = ParentController::esitime(strtotime($date));
            $datex = date('j F Y H:i', strtotime($date)) . ' WIB';
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            $id = $value['id'];
            $cat_name = isset($value['cat_name']) && !empty($value['cat_name']) ? $value['cat_name'] : '';
            $kategori = isset($value['kategori']) && !empty($value['kategori']) ? $value['kategori'] : isset($value['cat_slug']) && !empty($value['cat_slug']) ? $value['cat_slug'] : "";
            $slug = isset($value['slug']) ? $value['slug'] : "";
//            $linknya = \Yii::$app->urlManager->createAbsoluteUrl(['berita/detail', 'kategori' => $kategori, 'y' => $year, 'm' => $month, 'd' => $day, 'slug' => $slug, 'id' => $id]);
            $linknya = 'http://www.rajamobil.com/' . 'berita/' . $kategori . '/' . $year . '/' . $month . '/' . $day . '/' . $slug . '-' . $id . '.htm';
//            var_dump($url);die;
            $datenya = date('Y/m/d', strtotime(substr($value['scheduled_date'], 0, 10)));
            $pubdatenya = date('r', strtotime($value['scheduled_date']));
            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode(ucwords(strtolower($value['title'])));
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($linknya);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($pubdatenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($value['summary']);
            $description->appendChild($descriptiontext);

            if (isset($value['img_default']) && $value['img_default'] != '')
                $foto = $value['img_default'];
            elseif (isset($value['img_1']) && $value['img_1'] != '')
                $foto = $value['img_1'];
            elseif (isset($value['img_2']) && $value['img_2'] != '')
                $foto = $value['img_2'];
            elseif (isset($value['img_3']) && $value['img_3'] != '')
                $foto = $value['img_3'];
            elseif (isset($value['img_4']) && $value['img_4'] != '')
                $foto = $value['img_4'];
            elseif (isset($value['img_5']) && $value['img_5'] != '')
                $foto = $value['img_5'];
            elseif (isset($value['img_6']) && $value['img_6'] != '')
                $foto = $value['img_6'];
            elseif (isset($value['img_7']) && $value['img_7'] != '')
                $foto = $value['img_7'];
            else
                $foto = $value['image'][0]['path'];
            $image = $xml->createElement('image');
            $imagetext = $xml->createTextNode('http://img.rajamobil.com:8080/original/public/media/images/original/' . $foto);
            $image->appendChild($imagetext);
            if ($value["fullname"] != '') {
                if (strtolower($value["fullname"]) == 'andini') {
                    $penulisnya = 'Ediya Moralia';
                } elseif (strtolower($value["fullname"]) == 'arya') {
                    $penulisnya = 'Yogi Megah Perkasa';
                } else {
                    $penulisnya = ucwords($value["fullname"]);
                }
            } else {
                if (strtolower($value["userid_creator"]) == 'dipo') {
                    $penulisnya = 'Rio';
                } else {
                    $penulisnya = ucwords($value["userid_creator"]);
                }
            }

            $sumberfoto = $xml->createElement('sumberfoto');
            $sumberfototext = $xml->createTextNode(ucwords(strtolower($value["photo_source"])));
            $sumberfoto->appendChild($sumberfototext);

            $penulis = $xml->createElement('penulis');
            $penulistext = $xml->createTextNode($penulisnya);
            $penulis->appendChild($penulistext);

            $fulldesc = $xml->createElement('fulldesc');
            $fulldesctext = $xml->createTextNode($value['body']);
            $fulldesc->appendChild($fulldesctext);

            $kategori = $xml->createElement('kategori');
            $kategoritext = $xml->createTextNode($cat_name);
            $kategori->appendChild($kategoritext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($linknya);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($description);
            $item->appendChild($image);
            $item->appendChild($penulis);
            $item->appendChild($sumberfoto);
            $item->appendChild($fulldesc);
            $item->appendChild($kategori);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/artikelmobilfulldesc.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMobilbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mobilbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMobilbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mobilbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionToyotabekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'toyota',
            'mrk_id' => '32',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/toyotabekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionToyotabaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'toyota',
            'mrk_id' => '32',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/toyotabaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionHondabekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'honda',
            'mrk_id' => '15',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/hondabekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionHondabaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'honda',
            'mrk_id' => '15',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/hondabaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionDaihatsubekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'daihatsu',
            'mrk_id' => '12',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/daihatsubekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionDaihatsubaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'daihatsu',
            'mrk_id' => '12',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/daihatsubaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionSuzukibekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'suzuki',
            'mrk_id' => '31',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/suzukibekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionSuzukibaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'suzuki',
            'mrk_id' => '31',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/suzukibaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionNissanbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'nissan',
            'mrk_id' => '26',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/nissanbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionNissanbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'nissan',
            'mrk_id' => '26',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/nissanbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMitsubishibekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'mitsubishi',
            'mrk_id' => '25',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mitsubishibekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMitsubishibaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'mitsubishi',
            'mrk_id' => '25',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mitsubishibaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionBmwbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'bmw',
            'mrk_id' => '9',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/bmwbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionBmwbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'bmw',
            'mrk_id' => '9',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/bmwbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionKiabekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'kia',
            'mrk_id' => '19',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/kiabekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionKiabaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'kia',
            'mrk_id' => '19',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/kiabaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMazdabekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'mazda',
            'mrk_id' => '23',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mazdabekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMazdabaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'mazda',
            'mrk_id' => '23',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mazdabaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionHyundaibekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'hyundai',
            'mrk_id' => '16',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/hyundaibekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionHyundaibaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'hyundai',
            'mrk_id' => '16',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/hyundaibaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionFordbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'ford',
            'mrk_id' => '14',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/fordbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionFordbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'ford',
            'mrk_id' => '14',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/fordbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionChevroletbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'chevrolet',
            'mrk_id' => '11',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/chevroletbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionChevroletbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'chevrolet',
            'mrk_id' => '11',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/chevroletbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionVolkswagenbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'volkswagen',
            'mrk_id' => '33',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/volkswagenbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionVolkswagenbaru() {
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'volkswagen',
            'mrk_id' => '33',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/volkswagenbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMercedesbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'mercedes-benz',
            'mrk_id' => '24',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mercybekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionMercedesbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'mercedes-benz',
            'mrk_id' => '24',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/mercybaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionLandroverbekas() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'bekas',
            'merek' => 'land+rover',
            'mrk_id' => '21',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga_mobil'] != 0) {
                $prices = 'Rp ' . number_format($value['harga_mobil']);
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merkmobil']));
            $tipenya = ucwords(strtolower($value['tipemobil']));
            $modelnya = ucwords(strtolower($value['modelmobil']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower(\Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                                'merek' => $value["merkmobil"],
//                                'model' => $value['modelmobil'],
//                                'kondisi' => $value['kondisikendaraan'] == 1 ? "bekas" : "baru",
//                                'tahun' => $value['tahun'],
//                                'kota' => $value['city_name'],
//                                'tanggal' => date('Ymd', strtotime($value['datecreated'])),
//                                'id' => $value['id']
//                            ]));
            $_url = str_replace(' ', '+', strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merkmobil']) . '-' . str_replace(' ', '+', $value['modelmobil']) . '-bekas-tahun-' . $value['tahun'] . '-di-' . $value['city_name'] . '-' . date('Ymd', strtotime($value['datecreated'])) . '-' . $value['id'] . '.htm'));
//            var_dump($_url);die;
            $datenya = date('r', strtotime($value['datecreated']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/landroverbekas.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

    public function actionLandroverbaru() {
        $this->view->registerMetaTag(['name' => 'robots', 'content' => 'no index, no follow'], 'meta-robots');
        $xml = new DOMDocument("1.0", "UTF-8");
        $parentnode = $xml->createElement('rss');
        $parentnode->setAttribute('version', '2.0');
        $xml->appendChild($parentnode);
        $ad = $xml->createElement('channel');
        $paramArtikel = [
            'kondisi' => 'baru',
            'merek' => 'land+rover',
            'mrk_id' => '21',
            'limit' => 100
        ];

        $data = Yii::$app->rajamobil->curlApi('GET', 'databasemobil/search', $param = $paramArtikel);
        $data = $data['docs'];
//        var_dump($data);die;
        $title = $xml->createElement("title");
        $titleText = $xml->createTextNode('Bursa Jual Beli Mobil Baru dan Bekas Harga Murah - RajaMobil');
        $title->appendChild($titleText);

        $url = $xml->createElement("link");
        $urlText = $xml->createTextNode('http://www.rajamobil.com');
        $url->appendChild($urlText);

        $contents = $xml->createElement("description");
        $contentsText = $xml->createTextNode('Dapatkan informasi dan mobil impianmu di RajaMobil. Bursa jual beli aneka mobil baru dan bekas beragam merek dengan harga murah hanya disini');
        $contents->appendChild($contentsText);

        $language = $xml->createElement("language");
        $languageText = $xml->createTextNode('Id');
        $language->appendChild($languageText);

        $copyright = $xml->createElement("copyright");
        $copyrightText = $xml->createTextNode('Copyright 2015, Rajamobil.com');
        $copyright->appendChild($copyrightText);

        $a = date('r');

        $pubdate = $xml->createElement("pubdate");
        $pubdateText = $xml->createTextNode($a);
        $pubdate->appendChild($pubdateText);

        $item = $xml->createElement('image');

        $titlenya = $xml->createElement("title");
        $titledalemText = $xml->createTextNode('Rajamobil.com bursa jual beli mobil untuk Anda yang ingin mencari iklan mobil bekas atau baru. RajaMobil.com, Rajanya jual beli mobil.');
        $titlenya->appendChild($titledalemText);

        $urls = $xml->createElement("url");
        $urlsText = $xml->createTextNode('http://www.rajamobil.com/themes/rmperjuangan/images/logo/logo-rajamobil-2015.png');
        $urls->appendChild($urlsText);

        $link = $xml->createElement("link");
        $linkText = $xml->createTextNode('http://www.rajamobil.com');
        $link->appendChild($linkText);

        $width = $xml->createElement("width");
        $widthText = $xml->createTextNode('265');
        $width->appendChild($widthText);

        $height = $xml->createElement("height");
        $heightText = $xml->createTextNode('90');
        $height->appendChild($heightText);

        $item->appendChild($titlenya);
        $item->appendChild($urls);
        $item->appendChild($link);
        $item->appendChild($width);
        $item->appendChild($height);

        //BLOK Deskripsi Raja Mobil
        $ad->appendChild($title);
        $ad->appendChild($url);
        $ad->appendChild($contents);
        $ad->appendChild($language);
        $ad->appendChild($copyright);
        $ad->appendChild($pubdate);
        $ad->appendChild($item);

        foreach ($data as $value) {
            if ($value['kondisikendaraan'] == 0) {
                $k = 'baru';
                $warantynya = '1';
                $kelas = "mobilbaru";
            } else {
                $k = 'bekas';
                $warantynya = '0';
                $kelas = "mobilbekas";
            }

            if (!empty($value['city_name'])) {
                $lokasi = $value['city_name'];
                $lokasinya = $value['city_name'];
            } else {
                $lokasi = $value['nama_daerah'];
                $lokasinya = $value['nama_daerah'];
            }

            if ($value['harga1'] != 0) {
                $prices = 'Rp ' . number_format($value['harga1']) . (!empty($value['harga2']) ? ' - Rp.' . $value['harga2'] : '');
            } else {
                $prices = 'Hubungi Penjual';
            }
            $mereknya = ucwords(strtolower($value['merek']));
            $tipenya = ucwords(strtolower($value['tipe']));
            $modelnya = ucwords(strtolower($value['model']));

            $isinya = 'Mobil ' . $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' dijual di ' . $lokasinya . ', ' . $value['province_name'] . ', Harga Mobil ' . ucwords($k) . ' ' . $modelnya . ' ' . $tipenya . ' ' . $prices;
            $titles = $mereknya . ' ' . $modelnya . ' ' . ucwords($k) . ' Tahun ' . $value['tahun'] . ' ' . $lokasinya;
//            $datecreated = str_replace('-', '', date('Y-m-d', strtotime(isset($value['datecreated']) ? $value['datecreated'] : date('Y-m-d'))));
//            $_url = strtolower( \Yii::$app->urlManager->createAbsoluteUrl(['jual/mobil-detail',
//                'merek' => $value['merek'],
//                'model' => $value['model'],
//                'cityId' => $value['city_id'],
//                'modelId' => $value['car_model'],
//                'tahun' => $value['tahun']
//            ]));
//            var_dump($_url);die;
            $_url = strtolower('http://www.rajamobil.com/' . 'dijual-' . str_replace(' ', '+', $value['merek']) . '-' . str_replace(' ', '+', $value['model']) . '-' . $value['city_id'] . '-' . $value['car_model'] . '-' . $value['tahun'] . '.htm');
            $datenya = date('r', strtotime($value['modified']));

            $item = $xml->createElement('item');

            $title = $xml->createElement("title");
            $titleText = $xml->createTextNode($titles);
            $title->appendChild($titleText);

            $link = $xml->createElement("link");
            $linkText = $xml->createTextNode($_url);
            $link->appendChild($linkText);

            $pubdate = $xml->createElement("pubdate");
            $pubdateText = $xml->createTextNode($datenya);
            $pubdate->appendChild($pubdateText);

            $description = $xml->createElement('description');
            $descriptiontext = $xml->createTextNode($isinya);
            $description->appendChild($descriptiontext);

            $guid = $xml->createElement('guid');
            $guidtext = $xml->createTextNode($_url);
            $guid->appendChild($guidtext);

            $item->appendChild($title);
            $item->appendChild($link);
            $item->appendChild($pubdate);
            $item->appendChild($link);
            $item->appendChild($description);
            $item->appendChild($guid);
            $ad->appendChild($item);
            $parentnode->appendChild($ad);
        }
        $xml->formatOutput = true;
        $xml->save(Yii::$app->params['pathRss'] . "/landroverbaru.xml") or die("Error");

        echo "<xmp>" . $xml->saveXML() . "</xmp>";
    }

}
