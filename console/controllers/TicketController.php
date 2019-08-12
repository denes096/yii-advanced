<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/9/19
 * Time: 10:31 AM
 */
namespace console\controllers;

use common\models\Comment;
use common\models\Ticket;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class TicketController extends Controller
{
    private $author_isadmin;
    private $create_time;

    /**
     * @return int
     */
    public function actionClose()
    {
        $tickets_model = Ticket::find()->ofIsopen(true)->all();

        foreach ($tickets_model as $ticket_model) {

            $comment = Comment::getCommentById($ticket_model->getLastCommentId());
            $author_isadmin = $comment->user->is_admin;
            $create_time = $comment->create_time;
            $created = strtotime($create_time);
            $now = strtotime(date("Y-m-d H:i:s"));

            if(($created+60-3600 < $now) && $author_isadmin) {
                $ticket_model->is_open=false;
                try {
                    if (!$ticket_model->save()) {
                        Yii::error($ticket_model->getErrors());
                        return ExitCode::UNSPECIFIED_ERROR;
                    }
                    echo $ticket_model->title . " ticket closed!\n";
                } catch (\Exception $e) {
                    echo $ticket_model->title . " progblem during saving!\n";
                    return ExitCode::UNSPECIFIED_ERROR;
                }
            }
        }
        return ExitCode::OK;
    }
}