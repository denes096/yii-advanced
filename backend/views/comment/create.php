<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 11:19 AM
 */
/* @var $this yii\web\View */
/* @var $comment_model common\models\Comment */

use yii\helpers\Html;

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

 ?>

<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/comment/_form', [
        'comment_model' => $comment_model,
    ]) ?>

</div>
