<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
/* @var $comment_model common\models\Comment */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $this->render('/comment/_form', [
        'model' => $comment_model,
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
