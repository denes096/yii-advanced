<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/26/19
 * Time: 11:27 AM
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
    <h1>Personal informations</h1>

    <div class="personal-view">
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'email:email',
                'regtime',
                'lastlogintime',
            ],
        ]) ?>

    </div>