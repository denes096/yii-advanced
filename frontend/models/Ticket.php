<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/29/19
 * Time: 4:58 PM
 */

namespace frontend\models;


use app\models\TicketQuery;
use Yii;

class Ticket extends \common\models\Ticket
{

    public static function find()
    {
        return new TicketQuery(get_called_class());
    }
}