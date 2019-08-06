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

    //TODO make a loginform model if needed only for common user search
    public static function findByUserEmail($email)
    {
        return static::find(['email'=> $email])->where(['is_admin' => self::STATUS_COMMON])->one();
    }

    public function updateLoginTime()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->lastlogintime = date("Y-m-d H:i:s");
    }

}