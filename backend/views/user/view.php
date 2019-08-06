<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 2:41 PM
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $ticket common\models\Ticket */
/* @var $tickets common\models\Ticket */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title.'\'s all Tickets: ') ?></h1>

    <?php foreach ($tickets as $ticket): ?>
    <div class="row" style="padding: 10px" id="comment_div">
        <div class="col">
                <div class="col bg-primary" id="created_by_at">
                    <?= Html::encode("Created by: {$ticket->user->name} at: {$ticket->createtime}")?>
                </div>
                <div class="col bg-info" id="created_by_at">
                    <?= Html::encode($ticket->title)?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
