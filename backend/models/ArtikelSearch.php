<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Artikel;

/**
 * ArtikelSearch represents the model behind the search form about `backend\models\Artikel`.
 */
class ArtikelSearch extends Artikel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author', 'categori_id', 'status', 'viewed', 'user_create', 'user_update'], 'integer'],
            [['judul', 'summary', 'deskripsi', 'author_name', 'categori_name', 'sumber', 'schedule_date', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9', 'video', 'date_create', 'date_update', 'user_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Artikel::find();
        $query->orderBy(['id'   =>  SORT_DESC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author' => $this->author,
            'categori_id' => $this->categori_id,
            'schedule_date' => $this->schedule_date,
            'status' => $this->status,
            'viewed' => $this->viewed,
            'user_create' => $this->user_create,
            'user_update' => $this->user_update,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
        ]);

        $query->andFilterWhere(['like', 'judul', $this->judul])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'categori_name', $this->categori_name])
            ->andFilterWhere(['like', 'sumber', $this->sumber])
            ->andFilterWhere(['like', 'image1', $this->image1])
            ->andFilterWhere(['like', 'image2', $this->image2])
            ->andFilterWhere(['like', 'image3', $this->image3])
            ->andFilterWhere(['like', 'image4', $this->image4])
            ->andFilterWhere(['like', 'image5', $this->image5])
            ->andFilterWhere(['like', 'image6', $this->image6])
            ->andFilterWhere(['like', 'image7', $this->image7])
            ->andFilterWhere(['like', 'image8', $this->image8])
            ->andFilterWhere(['like', 'image9', $this->image9])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'user_by', $this->user_by]);
        
        

        return $dataProvider;
    }
    
    public static function getArtikelTerupdate(){
        return (new \yii\db\Query())
                ->select(['t.id','t.judul','t.summary','t.author_name','t.image1','t.date_create'])
                ->from('gab_artikel t')
                ->where('t.status ='.self::STATUS_AKTIF.' AND categori_id !='.Category::KATEGORI_ARTIKEL_TESTIMONI)
                ->limit(2)
                ->orderBy('date_create DESC')
                ->all();
        
    }
}
