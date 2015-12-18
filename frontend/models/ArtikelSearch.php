<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Artikel;

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
    
    public function getArtikelTerupdate(){
        return (new \yii\db\Query())
                ->select(['t.id','t.judul','t.summary','t.author_name','t.image1','t.date_create','t.categori_name'])
                ->from('jr_artikel t')
                ->where('t.status ='.self::STATUS_AKTIF. ' AND (t.schedule_date BETWEEN t.schedule_date AND NOW())')
                ->limit(5)
                ->orderBy('date_create DESC')
                ->all();
        
    }
    
    public function getArtikelPopular(){
        return (new \yii\db\Query())
                ->select(['t.id','t.judul','t.summary','t.author_name','t.image1','t.date_create','t.categori_name'])
                ->from('jr_artikel t')
                ->where('t.status ='.self::STATUS_AKTIF. ' AND (t.schedule_date BETWEEN t.schedule_date AND NOW()) AND (DATE(t.date_create) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY))')
                ->limit(10)
                ->orderBy('date_create DESC')
                ->all();
        
    }
    
    public function getArtikelLainnya($params = []){
//        $params = $_REQUEST;
        $condition = [];
        
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : \Yii::$app->params['pageSizeListview'];
        
        $order = [];
        
        $order[] = "t.date_create DESC";
        
        $tagTerkait = isset($params['tagterkait']) ? $params['tagterkait'] : '';
        $idExcept = isset($params['idExcept']) ? $params['idExcept'] : '';
        
        $condition[] = "t.status = ".self::STATUS_AKTIF." AND (t.schedule_date BETWEEN t.schedule_date AND NOW())";
        
        if($tagTerkait !== ''){
            $tagTerkait = explode(",", urldecode($tagTerkait));
            $tagQuery = "";
            foreach ($tagTerkait as $key => $value) {
                if($value != ""){
                    $tagQuery[] = 'tag LIKE "%'.trim(urldecode($value)).'%"';
                    $tagQuery[] = 'judul LIKE "%'.trim(urldecode($value)).'%"';
                }
            }
            $condition[] = "(".join(" OR ", $tagQuery).")";
//            $condition[] = "t.tag IN(:tag)";
        }
        if($idExcept !== ''){
            $condition[] = "t.id NOT IN(:idExcept)";
        }
        
        if (!empty($condition)) {
            $condition = " WHERE " . join(" AND ", $condition);
        }
        
        if(!empty($order)){
            $order = " ORDER BY " . (join(", ", $order));
        }
        
        $query = "SELECT 
                    t.id,
                    t.judul,
                    t.summary,
                    t.deskripsi,
                    t.author_name,
                    t.image1,
                    t.date_create,
                    t.categori_name,
                    t.sumber,
                    t.tag,
                    t.schedule_date,
                    t.viewed,
                    t.date_create
                  FROM
                    jr_artikel t
                  ".(isset($condition) ? $condition : "")."
                  ".(isset($order) ? $order : "")."
                  limit " . $start . ", " . $limit . "       
                ";
        $command = Yii::$app->db->createCommand($query);
//        if($tagTerkait !== ''){
//            $command->bindValue(':tag', "$tagTerkait");
//        };
        if($idExcept !== ''){
            $command->bindValue(':idExcept', "$idExcept");
        };
        $listArtikel = $command->queryAll();
        
//        echo $query;die;
        $queryCount = "
                        SELECT
                                    count(t.id) AS total                                     
                                FROM
                                    jr_artikel t
                                " . (isset($condition) ? $condition : "") . "
                                " . (isset($order) ? $order : "") . "       
                ";
        
        $commandCount = Yii::$app->db->createCommand($queryCount);
//        if($tagTerkait !== ''){
//            $commandCount->bindValue(':tag', "$tagTerkait");
//        };
        if($idExcept !== ''){
            $commandCount->bindValue(':idExcept', "$idExcept");
        };
        $countArtikel = $commandCount->queryAll();
        
        return [
            'status' => 1,
            'docs' => $listArtikel,
            'numFound' => $countArtikel
        ];
        
    }
    
    
    public function getArtikelById($params = []){
        $id = isset($params['id']) ? $params['id'] : '';
        
        return (new \yii\db\Query())
                ->select(['t.id','t.judul','t.summary','t.author_name','t.image1','t.date_create','t.categori_name','t.deskripsi','t.tag'])
                ->from('jr_artikel t')
                ->where('t.status ='.self::STATUS_AKTIF. (!empty($id) ? " AND t.id =".$id : ""))
                ->orderBy('date_create DESC')
                ->one();
        
    }
    
    public function searchArtikel($params = []){
        $condition = [];
        $order = [];
        
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : \Yii::$app->params['pageSizeListview'];
        
        $order[] = "t.date_create DESC";
        
        $cariBerita = isset($params['query']) ? $params['query'] : '';
        $katBerita = isset($params['kat']) ? str_replace('-', ' ', $params['kat']) : '';
        $tagBerita = isset($params['tagberita']) ? str_replace('-', ' ', $params['tagberita']) : '';
        $idExcept = isset($params['idExcept']) ? $params['idExcept'] : '';
//        var_dump($tagBerita);die;
        $condition[] = "t.status = ".self::STATUS_AKTIF." AND (t.schedule_date BETWEEN t.schedule_date AND NOW())";
        
        if($cariBerita !== ''){
            $condition[] = "t.judul LIKE :cari";
        };
        
        if($katBerita !== ''){
            $condition[] = "t.categori_name = :kat";
        }
        
        if($tagBerita !== ''){
            $tagBerita = explode(",", urldecode($tagBerita));
            $tagQuery = "";
            foreach ($tagBerita as $key => $value) {
                if($value != ""){
                    $tagQuery[] = 'tag LIKE "%'.trim(urldecode($value)).'%"';
                }
            }
            $condition[] = "(".join(" OR ", $tagQuery).")";
//            $condition[] = "t.tag IN(:tag)";
        }
        
        if($idExcept !== ''){
            $condition[] = "t.id NOT IN(:idExcept)";
        }
        
        if (!empty($condition)) {
            $condition = " WHERE " . join(" AND ", $condition);
        }
        
        if(!empty($order)){
            $order = " ORDER BY " . (join(", ", $order));
        }
        
        $query = "SELECT 
                    t.id,
                    t.judul,
                    t.summary,
                    t.deskripsi,
                    t.author_name,
                    t.image1,
                    t.date_create,
                    t.categori_name,
                    t.sumber,
                    t.tag,
                    t.schedule_date,
                    t.viewed,
                    t.date_create
                  FROM
                    jr_artikel t
                  ".(isset($condition) ? $condition : "")."
                  ".(isset($order) ? $order : "")."
                  limit " . $start . ", " . $limit . "       
                ";
        $command = Yii::$app->db->createCommand($query);
        if($cariBerita !== ''){
            $command->bindValue(':cari', "%$cariBerita%");
        };
        if($katBerita !== ''){
            $command->bindValue(':kat', "$katBerita");
        };
//        if($tagBerita !== ''){
//            $command->bindValue(':tag', "$tagBerita");
//        };
        if($idExcept !== ''){
            $command->bindValue(':idExcept', "$idExcept");
        };
        $listArtikel = $command->queryAll();
        
//        $querys = Yii::$app->db->createCommand("SELECT * FROM jr_artikel WHERE judul LIKE :catname")
//           ->bindValue(':catname', "%$cariBerita%")
//           ->queryAll();
//        echo '<pre>'; print_r($command->getRawSql());die;
        
        $queryCount = "
                        SELECT
                                    count(t.id) AS total                                     
                                FROM
                                    jr_artikel t
                                " . (isset($condition) ? $condition : "") . "
                                " . (isset($order) ? $order : "") . "       
                ";
        
        $commandCount = Yii::$app->db->createCommand($queryCount);
        if($cariBerita !== ''){
            $commandCount->bindValue(':cari', "%$cariBerita%");
        };
        if($katBerita !== ''){
            $commandCount->bindValue(':kat', "$katBerita");
        };
//        if($tagBerita !== ''){
//            $commandCount->bindValue(':tag', "$tagBerita");
//        };
        if($idExcept !== ''){
            $commandCount->bindValue(':idExcept', "$idExcept");
        };
        $countArtikel = $commandCount->queryAll();
        
        return [
            'status' => 1,
            'docs' => $listArtikel,
            'numFound' => $countArtikel
        ];
    }
    
}
