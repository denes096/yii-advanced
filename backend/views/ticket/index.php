<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 9:51 AM
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(['assignedrows'],'post'); ?>

    <div class="form-group" style="float: right;">
        <?= Html::submitButton('Assign', ['class' => 'btn btn-success',]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'user_id' => 'user.name:text:Author',
            'title',
            'modified_time',
            'is_open:boolean:Open',
            'admin_id' => 'admin.name:text:Assigned Admin',
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($searchModel) {
                return ['value' => $searchModel->id];
            }],
        ],
    ]); ?>

    <?php Html::endForm(); ?>

</div>
