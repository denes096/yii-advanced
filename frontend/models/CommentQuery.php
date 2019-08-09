<?php

namespace frontend\models;

use common\models\Comment;
/**
 * This is the ActiveQuery class for [[Comment]].
 *
 * @see Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function ofId($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}
