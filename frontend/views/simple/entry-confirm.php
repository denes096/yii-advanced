<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/23/19
 * Time: 1:29 PM
 */

use yii\helpers\Html;
?>
<p>You have entered the following information:</p>

<ul>
    <li><label>Name</label>: <?= Html::encode($model->name) ?></li>
    <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
</ul>
