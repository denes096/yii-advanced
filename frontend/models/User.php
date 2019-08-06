<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/29/19
 * Time: 11:15 AM
 */

namespace frontend\models;


class User extends \common\models\User
{

    public static function findByUserEmail($email)
    {
        return static::find()->where(['email'=> $email,'is_admin' => self::STATUS_COMMON])->one();
    }

    public function updateLoginTime()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->lastlogintime = date("Y-m-d H:i:s");
    }

}