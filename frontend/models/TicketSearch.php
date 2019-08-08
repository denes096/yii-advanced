<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/29/19
 * Time: 3:50 PM
 */

namespace frontend\models;

use app\models\TicketQuery;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class TicketSearch extends \common\models\TicketSearch
{

    public static function find()
    {
        return new TicketQuery(get_called_class());
    }

    public function search($params)
    {


        $query = Ticket::find()->where(['user_id' => \Yii::$app->user->getId()])->orderBy(['is_open' => SORT_DESC, 'createtime' => SORT_DESC]);

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
            'createtime' => $this->createtime,
            'is_open' => $this->is_open,
            'user_id' => $this->user_id,
            'admin_id' => $this->admin_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title]);

        return $dataProvider;
    }
}