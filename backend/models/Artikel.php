<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use backend\models\Artikel;
use backend\models\Category;
use backend\models\Tag;

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
 * @property string $tag
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
    private $_oldTag;
    
    const STATUS_NOT_AKTIF = 1;
    const STATUS_AKTIF = 0;
    const STATUS_KONFIRMASI = 2;
    const KATEGRI_BERITA = 7;

    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $img5;
    public $img6;
    public $img7;
    public $img8;
    public $img9;

    public static function tableName() {
        return '{{%artikel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['judul', 'summary', 'deskripsi', 'author', 'categori_id', 'sumber', 'schedule_date', 'status', 'image1', 'tag'], 'required', 'on' => 'create'],
            [['judul', 'summary', 'deskripsi', 'author', 'categori_id', 'sumber', 'schedule_date', 'status', 'tag'], 'required', 'on' => 'update'],
            [['deskripsi', 'video', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9', 'tag'], 'string'],
            [['author', 'categori_id', 'status', 'viewed', 'user_create', 'user_update', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6', 'img7', 'img8', 'img9'], 'integer'],
            [['schedule_date', 'date_create', 'date_update', 'tag'], 'safe'],
            [['author_name', 'categori_name', 'user_by'], 'string', 'max' => 30],
            [['judul'], 'string', 'max' => 75],
            [['summary'], 'string', 'max' => 250],
            [['sumber'], 'string', 'max' => 255],
            ['tag', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'],
            ['tag', 'normalizeTags'],
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
            'tag' => 'Tag',
            'user_create' => 'User Create',
            'user_update' => 'User Update',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'user_by' => 'User By',
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE => 'date_update'
                ],
                'value' => new \yii\db\Expression('NOW()')
            ],
            'blameable' => [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'user_create',
                'updatedByAttribute' => 'user_update'
            ]
        ];
    }

    public function beforeSave($insert) {
        
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                
            } else {
                
            }
            
//            $this->_oldTag = $this->tag;
            
            $this->user_by = \Yii::$app->user->identity->nama_depan;
            $this->schedule_date = date('Y-m-d H:i:s', strtotime(str_replace("-", "", $this->schedule_date)));

            isset($this->author) ? $this->author_name = User::getUser($this->author)->nama_depan : $this->author_name = NUll;
            isset($this->categori_id) ? $this->categori_name = Category::getCateory($this->categori_id)->nama : $this->categori_name = NUll;

            return true;
        } else {
            return false;
        }
    }

    public static function getStatus($key = '') {
        $status = [
            0 => 'Aktif',
            1 => 'Not Aktif',
            2 => 'Konfirmasi',
        ];

        if ($key !== '')
            return $status[$key];
        else
            return $status;
    }

    public function getImageFile($file) {
        $path_general = \Yii::$app->params['pathUpload'];
        $path_upload_image = $path_general . \Yii::$app->params['pathImageArtikel'];

        Yii::setAlias('@imageupload', $path_upload_image);
        if (!is_dir(Yii::getAlias('@imageupload') . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/')) {
            @mkdir(Yii::getAlias('@imageupload') . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/', 0755, true);
        }

        return !empty($file) ? \Yii::$app->params['pathUpload'] . \Yii::$app->params['pathImageArtikel'] . $file : NULL;
    }

    public function uploadImage($val) {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image' . $val);

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file names
        switch ($val):
            case 1:
                $this->image1 = $image->name;
                break;
            case 2:
                $this->image2 = $image->name;
                break;
            case 3:
                $this->image3 = $image->name;
                break;
            case 4:
                $this->image4 = $image->name;
                break;
            case 5:
                $this->image5 = $image->name;
                break;
            case 6:
                $this->image6 = $image->name;
                break;
            case 7:
                $this->image7 = $image->name;
                break;
            case 8:
                $this->image8 = $image->name;
                break;
            case 9:
                $this->image9 = $image->name;
                break;
        endswitch;



        $ext = end((explode(".", $image->name)));

        // generate a unique file name
        switch ($val):
            case 1:
                $this->image1 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 2:
                $this->image2 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 3:
                $this->image3 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 4:
                $this->image4 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 5:
                $this->image5 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 6:
                $this->image6 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 7:
                $this->image7 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 8:
                $this->image8 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
            case 9:
                $this->image9 = date('Y/m/d') . '/' . Yii::$app->security->generateRandomString() . ".{$ext}";
                break;
        endswitch;


        // the uploaded image instance
        return $image;
    }
    
    public static  function getArtikelByCategori($kategori, $limit = null) {
        $limit !== NULL ? $limit = $limit : $limit = "";
        return (new \yii\db\Query())
                ->select(['t.id','t.judul','t.summary','t.deskripsi','t.sumber'])
                ->from(['jr_artikel t'])
                ->where('t.categori_id=:kat ' ,[':kat'    =>  $kategori])
                ->limit($limit)
                ->orderBy('t.date_create DESC')
//                ->groupBy('t2.nama')
                ->all();
    }
    
    public function afterFind() {
        $this->_oldTag = $this->tag;
        parent::afterFind();
    }
    
    public function normalizeTags($attribute,$params){
        $this->tag = Tag::array2string(array_unique(Tag::string2array($this->tag)));
    }
        
    public function afterSave($insert, $changedAttributes) {
//        print_r(strtolower($this->tag));die;
        $tag = new Tag();
        $tag->updateFrequency(strtolower($this->_oldTag), strtolower($this->tag));
        parent::afterSave($insert, $changedAttributes);
    }
//    
//    public function afterDelete() {
//        if(parent::afterDelete()){
//            $tag = new Tag();
//            $tag->updateFrequency(ucwords($this->tag), '');
//            return true;
//        }else{
//            return false;
//        }
//        
//    }

}
