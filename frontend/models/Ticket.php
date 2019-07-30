<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/29/19
 * Time: 4:58 PM
 */

namespace frontend\models;


use Yii;

class Ticket extends \common\models\Ticket
{
    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        try {
            $this->user_id = Yii::$app->user->getId();
            self::createDate();
        } catch (\Exception $e) {
            //TODO error
        }

        return true;
    }

    public function createDate() {
        date_default_timezone_set('Europe/Budapest');
        $this->createtime = date("Y-m-d H:i:s");
    }

}