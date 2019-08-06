<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/30/19
 * Time: 3:29 PM
 */

namespace backend\models;


class User extends \common\models\User
{

    /**
     * @param \common\models\email $email
     * @return array|\common\models\User|\yii\db\ActiveRecord|null
     */
    public static function findByUserEmail($email)
    {
        return static::find()->where(['email'=> $email,'is_admin' => self::STATUS_ADMIN])->one();
    }

    /**
     *
     */
    public function updateLoginTime()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->lastlogintime = date("Y-m-d H:i:s");
    }
}