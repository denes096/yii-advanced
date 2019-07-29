<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/23/19
 * Time: 1:15 PM
 */

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\SimpleForm;

class SimpleController extends Controller
{
    /**
     * Simple method to print out the message parameter
     * @param string $message
     * @return string
     */
    public function actionSay( $message='hello' )
    {
        return $this->render('say', ['message' => $message]);
    }

    
    public function actionEntry()
    {
        $model = new SimpleForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }
}