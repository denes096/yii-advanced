<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/30/19
 * Time: 4:35 PM
 */

namespace backend\models;


use yii\data\ActiveDataProvider;

class UserSearch extends User
{

    public function rules()
    {
        return [
            [['regtime', 'lastlogintime'], 'safe'],
            [['is_admin'], 'boolean'],
            [['name', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique'],
            [['password'], 'string'],
        ];
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
        $query = User::find()->where(['is_admin' => User::STATUS_COMMON])->orWhere(['is_admin' => User::STATUS_ADMIN])->orderBy(['is_admin' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'regtime' => $this->regtime,
            'lastlogintime' => $this->lastlogintime,
            'is_admin' => $this->is_admin,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'password', $this->password]);

        return $dataProvider;
    }

}