<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 7/30/19
 * Time: 4:32 PM
 */

namespace backend\controllers;


use common\models\TicketSearch;
use common\models\User;
use backend\models\UserSearch;
use backend\models\UpdateUserForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->is_admin;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single User model's tickets.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'tickets' => $this->findModel($id)->tickets,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);

        $model = new UpdateUserForm();
        $model->fillFrom($user);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->fillTo($user);
            if(!$user->save()){
                //TODO hibaüzenet
            } else {
                //TODO Siker
            }
            Yii::$app->session->setFlash('success','Your account has been modified successfully');
            return $this->redirect(['profile', 'id' => $user->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return string|\yii\web\Response
     */
    public function actionProfile($id)
    {
        if (!Yii::$app->user->isGuest && $id == Yii::$app->user->getId()) {
            $model = User::findOne($id);
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['site/index']);
    }


}