<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/9/19
 * Time: 10:31 AM
 */
namespace console\controllers;

use common\models\Ticket;
use yii\console\Controller;

class TicketcloseController extends Controller
{


    /**
     * @return int
     */
    public function actionClose()
    {
        date_default_timezone_set('Europe/Budapest');
        $tickets_model = Ticket::find()->ofIsopen(true)->all();

        foreach ($tickets_model as $ticket_model) {
            $author_isadmin = false;
            $create_time = date("Y-m-d H:i:s");

            foreach ($ticket_model->comments as $comment) {
                $author_isadmin = $comment->user->is_admin;
                $create_time = $comment->create_time;
            }

            $created = strtotime($create_time);
            $now = strtotime("now");
            $diff = $now-$created;
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

            if ($author_isadmin && $minutes>1) {
                $ticket_model->is_open=false;
                try {
                    $ticket_model->save();
                } catch (\Exception $e) {
                    echo 'progblem during saving';
                }
            }
        }
        return 0;
    }
}