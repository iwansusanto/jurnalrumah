<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use frontend\models\Artikel;

/**
 * This is the model class for table "{{%artikel}}".
 *
 * @property integer $id
 * @property string $judul
 * @property string $summary
 * @property string $deskripsi
 * @property integer $author
 * @property string $author_name
 * @property integer $categori_id
 * @property string $categori_name
 * @property string $sumber
 * @property string $schedule_date
 * @property integer $status
 * @property integer $viewed
 * @property string $image1
 * @property string $image2
 * @property string $image3
 * @property string $image4
 * @property string $image5
 * @property string $image6
 * @property string $image7
 * @property string $image8
 * @property string $image9
 * @property string $video
 * @property integer $user_create
 * @property integer $user_update
 * @property string $date_create
 * @property string $date_update
 * @property string $user_by
 */
class Artikel extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const STATUS_NOT_AKTIF = 1;
    const STATUS_AKTIF = 0;
    const STATUS_KONFIRMASI = 2;
    const KATEGORI_BERITA = 7;
    const BERITA_TIPS = 8;
    const BERITA_PERUMAHAN = 9;

    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $img5;
    public $img6;
    public $img7;
    public $img8;
    public $img9;

    public $txtcari;
    
    public static function tableName() {
        return '{{%artikel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['judul', 'summary', 'deskripsi', 'author', 'categori_id', 'sumber', 'schedule_date', 'status', 'image1'], 'required', 'on' => 'create'],
            [['judul', 'summary', 'deskripsi', 'author', 'categori_id', 'sumber', 'schedule_date', 'status'], 'required', 'on' => 'update'],
            [['deskripsi', 'video', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9'], 'string'],
            [['author', 'categori_id', 'status', 'viewed', 'user_create', 'user_update', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6', 'img7', 'img8', 'img9'], 'integer'],
            [['schedule_date', 'date_create', 'date_update', 'txtcari'], 'safe'],
            [['author_name', 'categori_name', 'user_by'], 'string', 'max' => 30],
            [['judul'], 'string', 'max' => 75],
            [['summary'], 'string', 'max' => 250],
            [['sumber'], 'string', 'max' => 255],
            [['image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9'], 'file', 'extensions' => ['jpeg', 'jpg', 'png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'judul' => 'Judul',
            'summary' => 'Summary',
            'deskripsi' => 'Deskripsi',
            'author' => 'Author',
            'author_name' => 'Author',
            'categori_id' => 'Kategori',
            'categori_name' => 'Kategori',
            'sumber' => 'Sumber',
            'schedule_date' => 'Schedule Date',
            'status' => 'Status',
            'viewed' => 'Viewed',
            'image1' => 'Image File',
            'image2' => 'Image File 2',
            'image3' => 'Image File 3',
            'image4' => 'Image File 4',
            'image5' => 'Image File 5',
            'image6' => 'Image File 6',
            'image7' => 'Image File 7',
            'image8' => 'Image File 8',
            'image9' => 'Image File 9',
            'video' => 'Video',
            'user_create' => 'User Create',
            'user_update' => 'User Update',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'user_by' => 'User By',
        ];
    }

}
