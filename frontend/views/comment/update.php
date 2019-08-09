<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $commentModel common\models\Comment */

$this->title = 'Update Comment: ' . $commentModel->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $commentModel->id, 'url' => ['view', 'id' => $commentModel->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'commentModel' => $commentModel,
    ]) ?>

</div>
