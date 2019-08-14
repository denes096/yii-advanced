<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 2:41 PM
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $ticket common\models\Ticket */
/* @var $tickets common\models\Ticket */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title.'\'s all Tickets: ') ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $index, $widget, $grid){
            if(!$model->is_open){
                return ['class' => 'warning'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'user.name:text:created by',
            'createtime:text:created at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('View', "/ticket/view/{$model->id}");
                    },
                ],
            ],
        ],
    ]); ?>

</div>
