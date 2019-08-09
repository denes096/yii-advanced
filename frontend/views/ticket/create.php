<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticketModel common\models\Ticket */
/* @var $commentModel common\models\Comment */

$this->title = 'Create Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'ticketModel' => $ticketModel,
        'commentModel' => $commentModel,
    ]) ?>

</div>
