<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 10:46 AM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ticket */
/* @var $comments common\models\Comment */
/* @var $comment common\models\Comment */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <h1><?= Html::encode('Ticket: '.$this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'is_open:boolean',
            'user_id' => 'user.name:text:Created by',
            'admin_id' => 'admin.name:text:Ticket Admin',
        ],
    ]) ?>

    <?php foreach ($comments as $comment): ?>
        <div class="row" style="padding: 10px" id="comment_div">
            <div class="col">
                <?php if($comment->user->is_admin == true) { ?>
                    <div class="col bg-danger" id="created_by_at">
                <?php } else { ?>
                    <div class="col bg-primary" id="created_by_at">
                <?php }; ?>
                    <?=Html::encode("Created by: {$comment->user->name} at: {$comment->create_time}")?>
                </div>
            </div>
            <div class="col bg-info">
                <?= Html::encode("{$comment->description}") ?>
            </div>
        </div>
    <?php endforeach; ?>

    <p>
        <?= Html::a('Reply', ['ticket/reply/'.$model->id], ['class' => 'btn btn-success']) ?>
    </p>

</div>
