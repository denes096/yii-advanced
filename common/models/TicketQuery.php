<?php

namespace common\models;

use common\models\Ticket;

/**
 * This is the ActiveQuery class for [[Ticket]].
 *
 * @see Ticket
 */
class TicketQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ticket[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ticket|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param integer $id
     * @return TicketQuery
     */
    public function ofId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param boolean $isopen
     * @return TicketQuery
     */
    public function ofIsopen($isopen)
    {
        return $this->andWhere(['is_open' => $isopen]);
    }

    public function ofUserId($id)
    {
        return $this->andWhere(['user_id' => $id]);
    }


}
