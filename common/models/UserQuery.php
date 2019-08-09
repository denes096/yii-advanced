<?php
namespace frontend\models;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param integer $id
     * @return UserQuery
     */
    public function ofId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param string $email
     * @return UserQuery
     */
    public function ofEmail($email)
    {
        return $this->andWhere(['email' => $email]);
    }

    /**
     * @param boolean $is_admin
     * @return UserQuery
     */
    public function ofIsAdmin($is_admin)
    {
        return $this->andWhere(['is_admin' => $is_admin]);
    }
}
