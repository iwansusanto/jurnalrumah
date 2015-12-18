<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Warna;
use \app\models\Category;
use app\models\OutletworkshopParentCategory;
use app\models\MobilMerek;
use yii\imagine\Image;

class Jurnalrumah extends Component {

    
    public function slug($string) {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }

    public function potongjudul($judul, $count = "") {
        if ($count == "") {
            $count = 50;
        } else {
            $count = $count;
        }
        $_title = $judul;
        if (strlen($_title) > $count) {
            $_title = substr(strip_tags($_title), 0, $count);
            while (substr($_title, -1) != ' ')
                $_title = substr($_title, 0, -1);
            $_title = trim($_title) . '..';
        }
        return $_title;
    }

    
    public function isMobile() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
            return TRUE;
        else
            return FALSE;
    }

    public function cekWaktuTayang($date = "") {

        $time_ago = strtotime($date);
        $cur_time = time();
        $time_diff = $cur_time - $time_ago;
        $seconds = $time_diff;
        $minutes = round($time_diff / 60);
        $hours = round($time_diff / 3600);

        $cek_time_ago = "Not Set";
        if ($seconds <= 60):
            $cek_time_ago = $seconds . " Detik lalu";
        elseif ($minutes <= 60):
            $cek_time_ago = $minutes . " Menit lalu";
        elseif ($hours <= 24):
            $cek_time_ago = $hours . " Jam lalu";
        else:
            $cek_time_ago = $date;
        endif;
        return $cek_time_ago;
    }

   public function lihatImageDetail($img = "", $size = "", $kategori = "") {
        $path_folder_upload = Yii::$app->params['pathUpload']; // url folder general
        $url_folder_general = Yii::$app->params['urlGeneral']; // url folder general
        $url_no_image = Yii::$app->params['urlNoImage']; // url no image
        $path_image_slider = Yii::$app->params['pathImageSlider']; // url image slider
        $path_image_artikel = Yii::$app->params['pathImageArtikel']; // url image artikel
        $path_image_user = Yii::$app->params['pathImageUser']; // url image produk

        $imageUrl = "";

        if (isset($img) && ($img != '')):
            if ($kategori == 'slider'):
                if (file_exists($path_folder_upload . $path_image_slider . $img)): // cek jika image nya tidak ada di server
                    $imageUrl = $url_folder_general . $path_image_slider . $img;
                else:
                    $imageUrl = $url_folder_general . $url_no_image;
                endif;
            elseif ($kategori == 'artikel'):
                if (file_exists($path_folder_upload . $path_image_artikel . $img)): // cek jika image nya tidak ada di server
                    $imageUrl = $url_folder_general . $path_image_artikel . $img;
                else:
                    $imageUrl = $url_folder_general . $url_no_image;
                endif;
            elseif ($kategori == 'user'):
                if (file_exists($path_folder_upload . $path_image_user . $img)): // cek jika image nya tidak ada di server
                    $imageUrl = $url_folder_general . $path_image_user . $img;
                else:
                    $imageUrl = $url_folder_general . $url_no_image;
                endif;
            endif;
        else: // jika img kosong
            if ($kategori == 'slider'):
                $imageUrl = $url_folder_general.$url_no_image;
            elseif ($kategori == 'artikel'):
                $imageUrl = $url_folder_general.$url_no_image;
            elseif ($kategori == 'user'):
                $imageUrl = $url_folder_general.$url_no_image;
            endif;
        endif;

        return $imageUrl;
    }

    

    public static function convertToTanggal($date, $type) {
        $tanggalIndo = "";
        $tanggal = date('d', strtotime($date));
        $tanggal = intval($tanggal);
        $bulan = date('m', strtotime($date));
        $bulan = intval($bulan) - 1;
        $tahun = date('Y', strtotime($date));
        $jam = date('H', strtotime($date));
        $menit = date('i', strtotime($date));
        $day = date('w', strtotime($date));

        $bulanArray = array("Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $bulanIndo = $bulanArray[$bulan];

        $hariArray = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
        $hariIndo = $hariArray[$day];

        if ($type == 1) {
            $tanggalIndo = $tanggal . " " . $bulanIndo . " " . $tahun;
        } else if ($type == 2) {
            $tanggalIndo = $tanggal . " " . $bulanIndo;
        } else if ($type == 3) {
            $tanggalIndo = $tanggal . " " . $bulanIndo . " " . $tahun . " " . $jam . ":" . $menit . ' WIB';
        } else if ($type == 4) {
            $tanggalIndo = $hariIndo . " / " . date('d-m-Y', strtotime($date));
        } else if ($type == 5) {
            $tanggalIndo = $hariIndo . ", " . date('d', strtotime($date)) . " " . $bulanIndo . " " . date('Y', strtotime($date));
        } else {
            //$tanggalIndo = $tanggal." ".$bulanIndo." ".$tahun." ".$jam." ".$menit;
            $tanggalIndo = $tanggal . " " . $bulanIndo . " " . $tahun . " &nbsp|&nbsp" . $jam . ":" . $menit . ' WIB';
        }

        return $tanggalIndo;
    }

    public function encryptIt($q) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return( $qEncoded );
    }

    public function decryptIt($q) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return( $qDecoded );
    }

    public function isVaidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
    }
    
    public function cekwaktutayangdetail( $ptime ){
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
                $r = floor( $d );
                // return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' lalu';
                return $r . ' ' . $str . ' lalu';
            }
        }
    }
}
