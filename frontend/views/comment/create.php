<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $commentModel common\models\Comment */

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/comment/_form', [
        'commentModel' => $commentModel,
    ]) ?>

</div>
