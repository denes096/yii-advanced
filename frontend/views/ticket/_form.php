<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $ticketModel common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
/* @var $commentModel common\models\Comment */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($ticketModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $this->render('/comment/_form', [
        'commentModel' => $commentModel,
        'form' => $form,
    ]) ?>


    <?php ActiveForm::end(); ?>

</div>
