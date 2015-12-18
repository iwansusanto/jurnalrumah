<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    public static function string2array($tags) {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags) {
        return implode(', ', $tags);
    }

    public function updateFrequency($oldTags, $newTags) {
        $oldTags = self::string2array($oldTags);
        $newTags = self::string2array($newTags);
        $this->addTags(array_values(array_diff($newTags, $oldTags)));
//        print_r(array_values(array_diff($oldTags, $newTags)));die;
        $this->removeTags(array_values(array_diff($oldTags, $newTags)));
    }

    public function addTags($tags) {
        $updateTag = Tag::findOne([
            'name'  =>  $tags
        ]);
        if(!empty($updateTag)){
            $updateTag->updateCounters(['frequency' => 1]);
        };
        
        
        foreach ($tags as $name) {
            if (empty(Tag::findOne(['name' => $name]))) {
                $tag = new Tag();
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            }
        }
    }

    public function removeTags($tags) {
        if (empty($tags))
            return;
        
        $updateTag = Tag::findOne([
            'name'  =>  $tags
        ]);
        foreach ($tags as $name){
            $updateTag = Tag::findOne([
                'name'  =>  $name
            ]);
            if(!empty($updateTag)){
                 $updateTag->updateCounters(['frequency' => -1]);
            }
        }
        
        
        Tag::deleteAll(['frequency' => '<=0']);
    }

}
