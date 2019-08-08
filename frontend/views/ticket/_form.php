<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
/* @var $comment_model common\models\Comment */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $this->render('/comment/_form', [
        'comment_model' => $comment_model,
        'form' => $form,
    ]) ?>


    <?php ActiveForm::end(); ?>

</div>
