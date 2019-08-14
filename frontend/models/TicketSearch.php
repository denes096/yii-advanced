<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/29/19
 * Time: 3:50 PM
 */

namespace frontend\models;

use common\models\Ticket;
use common\models\TicketQuery;
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


        $query = Ticket::find()->ofUserId(\Yii::$app->user->getId())->orderBy(['is_open' => SORT_DESC, 'createtime' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
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