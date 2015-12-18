<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $nama_depan
 * @property string $nama_belakang
 * @property string $email
 * @property string $username
 * @property string $alamat
 * @property integer $telp
 * @property integer $jenis_kelamin
 * @property integer $pict
 * @property string $password
 * @property string $deskripsi
 * @property integer $type_user
 * @property integer $newsletter
 * @property integer $activation_code
 * @property integer $status
 * @property string $last_login
 * @property string $salt
 * @property integer $role
 * @property string $date_create
 * @property string $date_update
 * @property integer $user_create
 * @property integer $user_update
 */
class User extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const STATUS_ACTIVE = 0;
    const STATUS_NOTACTIVE = 1;
    const STATUS_BANNED = 2;
    
    const TYPE_USER_ADMIN = 2;
    const TYPE_USER_SUPERADMIN = 3;

    public $retypepass;
    public $oldpass;
    public $newpass;

    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nama_depan', 'email', 'alamat', 'jenis_kelamin', 'password', 'type_user', 'status', 'role'], 'required', 'on' => 'create'],
            [['nama_depan', 'email', 'alamat', 'jenis_kelamin', 'password', 'type_user', 'status', 'role'], 'required', 'on' => 'update'],
            [['jenis_kelamin', 'type_user', 'newsletter', 'status', 'user_create', 'user_update'], 'integer'],
            [['password', 'deskripsi', 'salt', 'pict','role'], 'string'],
            [['retypepass', 'oldpass', 'newpass'], 'string', 'on' => 'update'],
            [['last_login', 'date_create', 'date_update'], 'safe'],
            [['nama_depan', 'nama_belakang', 'email','username'], 'string', 'max' => 30],
            [['activation_code', 'telp'], 'string', 'max' => 15],
            [['alamat'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['email'], 'validasi_email_active', 'on' => 'create'],
            ['retypepass','cekNewpassword', 'skipOnEmpty' => false], // retype password biarkan kosong jika new password nya kosong
//            ['retypepass', 'required', 'when' => function($model) {
//                return $model->newpass > 1;
//            }],
            ['retypepass','cekNewpassword','on'   =>  'update'], // retype password wajib di isi jika new password tidak kosong
            ['retypepass', 'compare', 'compareAttribute' => 'newpass', 'message' => 'Password tidak sama dengan di atas', 'on' => 'update'],
            ['oldpass','cekOldpassword','on'   =>  'update'],
            [['pict'], 'file', 'extensions' => ['jpeg', 'jpg', 'png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nama_depan' => 'Nama',
            'nama_belakang' => 'Nama Belakang',
            'email' => 'Email',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'jenis_kelamin' => 'Jenis Kel',
            'pict' => 'Foto',
            'password' => 'Password',
            'deskripsi' => 'Deskripsi',
            'type_user' => 'Type',
            'newsletter' => 'Newsletter',
            'activation_code' => 'Activation Code',
            'status' => 'Status',
            'last_login' => 'Last Login',
            'salt' => 'Salt',
            'role' => 'Role',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'user_create' => 'User Create',
            'user_update' => 'User Update',
            'oldpass' => 'Password Lama',
            'newpass' => 'Password Baru',
            'retypepass' => 'Ketik Ulang Password'
        ];
    }
    
    public function cekNewpassword($attribute){
        if(!empty($this->newpass) && empty($this->retypepass)){
            $this->addError($attribute, "Ketik ulang password di atas");
        }
    }
    
    public function cekOldpassword($attribute){
        $user = User::findOne([
            'id'    =>  $this->id
        ]);
        
        if($user->password != sha1($this->salt.$this->oldpass)){
            $this->addError($attribute, "Password yang Anda masukkan tidak sama dengan password saat ini");
        }
    }

    public function validasi_email_active($attribute) {
        // cek email dan status nya blm aktif
        $user = self::findOne([
                    'email' => $this->email,
                    'status' => self::STATUS_ACTIVE
        ]);

        if ($user !== NULL) {
            $this->addError($attribute, 'Maaf email yang Anda masukkan telah terdaftar');
        }
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
                $this->activation_code = md5($this->email);
                $this->salt = sha1(\Yii::$app->params['salt'] . $this->email);
                $this->password = sha1($this->salt . $this->password);
            } else {
                
            }
            
            $this->username = $this->email;
            return true;
        } else {
            return false;
        }
    }

    public static  function getStatus($key = '') {
        $status = [
            0 => 'Aktif',
            1 => 'Not Aktif',
            2 => 'Banned'
        ];

        if ($key !== '')
            return $status[$key];
        else
            return $status;
    }

    public static function getType($key = '') {
        $type = [
            0 => 'Biasa',
//            1 => 'Reseller',
            2 => 'Admin',
//            3 => 'Super Admin'
        ];
        
        if(\Yii::$app->user->identity->role == 'Superadmin'): // jika superadmin maka tambah level
            array_push($type, 'Super Admin');
        endif;

        if ($key !== '')
            return $type[$key];
        else
            return $type;
    }

    public static  function getJenisKel($key = '') {
        $jenke = [
            0 => 'Perempuan',
            1 => 'Laki-laki',
        ];

        if ($key !== '')
            return $jenke[$key];
        else
            return $jenke;
    }
    
    public static  function getAuthor(){
        return User::find()
                ->select('id, nama_depan')
                ->where('status ='.self::STATUS_ACTIVE.' AND type_user <> '.self::TYPE_USER_SUPERADMIN)
                ->all();
    }
    
    public static  function getUser($id){
        return User::find()
                ->select('id, nama_depan')
                ->where('id ='.$id)
                ->one();
    }
    
    public  function getImageFile() 
    {
        $path_general = \Yii::$app->params['pathUpload'];
        $path_upload_image = $path_general . \Yii::$app->params['pathImageUser'];
        
        Yii::setAlias('@imageupload', $path_upload_image);
        if (!is_dir(Yii::getAlias('@imageupload') . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/')) {
            @mkdir(Yii::getAlias('@imageupload') . '/' . date('Y')  . '/' . date('m') . '/' . date('d') . '/', 0755, true);
        }
        return isset($this->pict) ? \Yii::$app->params['pathUpload'] . \Yii::$app->params['pathImageUser'] . $this->pict : null;
    }
    
    public function uploadImage(){
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'pict');
 
        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }
 
        // store the source file names
        $this->pict = $image->name;
        $ext = end((explode(".", $image->name)));
 
        // generate a unique file name
        $this->pict = date('Y/m/d').'/'.Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $image;
        
    }
    
    public function deleteImage() {
        $file = $this->getImageFile();
 
        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }
 
        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }
 
        // if deletion successful, reset your file attributes
        $this->pict = null;
 
        return true;
    }

}
