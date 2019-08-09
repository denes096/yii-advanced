<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $updateUserModel common\models\User */

$this->title = 'Update User: ' . $updateUserModel->name;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'updateUserModel' => $updateUserModel,
    ]) ?>

</div>
