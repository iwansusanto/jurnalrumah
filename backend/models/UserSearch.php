<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'telp', 'jenis_kelamin', 'type_user', 'newsletter', 'activation_code', 'status', 'role', 'user_create', 'user_update'], 'integer'],
            [['nama_depan', 'nama_belakang', 'email', 'alamat', 'password', 'deskripsi', 'last_login', 'salt', 'date_create', 'date_update'], 'safe'],
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
        $query = User::find();

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
            'telp' => $this->telp,
            'jenis_kelamin' => $this->jenis_kelamin,
            'type_user' => $this->type_user,
            'newsletter' => $this->newsletter,
            'activation_code' => $this->activation_code,
            'status' => $this->status,
            'last_login' => $this->last_login,
            'role' => $this->role,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'user_create' => $this->user_create,
            'user_update' => $this->user_update,
        ]);

        $query->andFilterWhere(['like', 'nama_depan', $this->nama_depan])
            ->andFilterWhere(['like', 'nama_belakang', $this->nama_belakang])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'salt', $this->salt]);

        if(\Yii::$app->user->identity->role != 'superadmin'):
            $query->andWhere('role <> "superadmin"'
                    );
        endif;
        return $dataProvider;
    }
}
