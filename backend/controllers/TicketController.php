<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 8/5/19
 * Time: 9:35 AM
 */

namespace backend\controllers;


use backend\models\TicketSearch;
use backend\models\User;
use common\models\Comment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Ticket;

class TicketController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'comments' => $this->findModel($id)->comments,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ticket model.
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
     * @param integer $id
     * @return string|\yii\web\Response
     */
    public function actionReply($id)
    {
        $comment_model = new Comment();
        $comment_model->ticket_id = $id;

        if ($comment_model->load(Yii::$app->request->post()) && $comment_model->save()) {
            return $this->redirect(['view', 'id' => $comment_model->ticket_id]);
        }

        return $this->render('/comment/create', [
            'comment_model' => $comment_model,
        ]);
    }

    /**clsoses the selected ticket
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionClose($id){
        $ticket = $this->findModel($id);
        $ticket->is_open = false;
        $ticket->save();

        return $this->redirect('/ticket/'.$id);
    }

    /**
     * Gets the selected rows when admin wants to handle the ticket
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAssignedrows()
    {
        $select = Yii::$app->request->post('selection');
        if(!empty($select)) {
            foreach ($select as $id) {
                $model = self::findModel($id);
                $model->admin_id = Yii::$app->user->id;
                if(!$model->save()) {
                    Yii::$app->session->setFlash('Cannot assign!');
                }
            }
        };

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}