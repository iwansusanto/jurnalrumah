<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $nama
 * @property string $deskripsi
 * @property integer $parent_category
 * @property integer $status
 * @property string $date_create
 * @property string $date_update
 * @property integer $user_create
 * @property integer $user_update
 * @property string $user_by
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_AKTIF = 0;
    const STATUS_NOT_AKTIF = 1;
    
    const KATEGORI_ARTIKEL = 1;
    const KATEGORI_PRODUK = 2;
    
    const KATEGORI_ARTIKEL_TESTIMONI = 4;


    public $sub_category;

    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'deskripsi', 'status'], 'required','on'   =>  'create'],
            [['nama', 'deskripsi', 'status'], 'required','on'   =>  'update'],
            [['deskripsi'], 'string'],
            [['parent_category', 'status', 'user_create', 'user_update','sub_category'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['nama', 'user_by'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'deskripsi' => 'Deskripsi',
            'parent_category' => 'Parent Category',
            'status' => 'Status',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'user_create' => 'User Create',
            'user_update' => 'User Update',
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
            $this->user_by = \Yii::$app->user->identity->nama_depan;
            if(!empty($this->sub_category)){
                $this->parent_category = $this->sub_category;
            }else{
                empty($this->parent_category) ? $this->parent_category = 0 : $this->parent_category = $this->parent_category;
            }
            
            return true;
        } else {
            return false;
        }
    }
    
    public static function getStatus($key = '') {
        $status = [
            0 => 'Aktif',
            1 => 'Not Aktif',
        ];

        if ($key !== '')
            return $status[$key];
        else
            return $status;
    }
    
    public static function getParentCategorys($id = ''){
        $id !== '' ? $condition = ' AND id <> '.$id : $condition = '';
        
        return Category::find()
                ->where('parent_category = 0 AND status = '.self::STATUS_AKTIF.$condition)
                ->all();
    }
    
    public static function getCateory($id){
        return Category::find()
                ->select(['id', 'nama', 'parent_category'])
                ->where('id ='.$id)
                ->one();
    }
    
    public static function getCategories($id_parent, $id = ''){
        $id !== '' ? $condition = ' AND t2.id <> '.$id : $condition = '';
        
        return (new \yii\db\Query())
                ->select([  't1.id AS id_level1', 't1.nama AS level1', 
                            't2.id AS id_level2', 't2.nama AS level2',
                            't3.id AS id_level3', 't3.nama AS level3',
                            't4.id AS id_level4', 't4.nama AS level4'])
                ->from(['jr_category t1'])
                ->join('LEFT OUTER JOIN','jr_category t2','t2.parent_category = t1.id')
                ->join('LEFT OUTER JOIN','jr_category t3','t3.parent_category = t2.id')
                ->join('LEFT OUTER JOIN','jr_category t4','t4.parent_category = t3.id')
                ->where('t1.id=:parent '.$condition ,[':parent'    =>  $id_parent])
                ->orderBy('t2.nama ASC')
//                ->groupBy('t2.nama')
                ->all();
//        return Category::find()
//                ->select('id, nama')
//                ->where('parent_category ='.$id_parent)
//                ->all();
    }
}
