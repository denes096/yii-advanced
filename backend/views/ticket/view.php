<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 10:46 AM
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\FrontendAsset;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ticket */
/* @var $comments common\models\Comment */
/* @var $comment common\models\Comment */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$frontend = FrontendAsset::register($this);
?>
<div class="ticket-view">

    <h1><?= Html::encode('Ticket: '.$this->title) ?></h1>

    <div class="row" style="padding: 15px">
        <div class="col">
    <?= Html::beginForm(['close','id' => $model->id]); ?>

    <?php if($model->is_open) {
        echo Html::submitButton('Close Ticket', ['class' => 'submit btn btn-danger']);
        }
    ?>

    <?= Html::endForm(); ?>

        </div>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'is_open:boolean',
            'user_id' => 'user.name:text:Created by',
            'admin_id' => 'admin.name:text:Ticket Admin',
        ],
    ]) ?>

    <?php foreach ($comments as $comment): ?>
        <div class="row" style="padding: 15px" id="comment_div">
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
            <div class="col bg-info text-center" >

                <?= Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/images/'.$comment->id.'.jpg', ['width' => '400px']) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <p>
        <?php
            if($model->admin_id == Yii::$app->user->id && $model->is_open == true) {
               echo Html::a('Reply', ['ticket/reply/' . $model->id], ['class' => 'btn btn-success']);
            }
        ?>
    </p>

</div>
