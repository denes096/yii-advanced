<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 11:21 AM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $comment_model common\models\Comment */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($comment_model, 'description')->textarea(['rows' => 10]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
