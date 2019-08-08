<?php

namespace frontend\controllers;

use common\models\Comment;
use frontend\models\CommentSearch;
use frontend\models\Ticket;
use frontend\models\UserSearch;
use Yii;
use frontend\models\TicketSearch;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
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
//        if(!$this->validateIdentity($id)) {
//            return $this->redirect(['ticket/']);
//        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'comments' => $this->findModel($id)->comments,
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ticket();
        $comment_model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $comment_model->ticket_id = $model->id;

            if($comment_model->load(Yii::$app->request->post()) && $comment_model->save()) {
                $comment_model->asd = UploadedFile::getInstance($comment_model,'asd');
                if($comment_model->asd) {
                    $comment_model->upload();
                    $comment_model->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'comment_model' => $comment_model,
        ]);
    }

//    /**
//     * Updates an existing Ticket model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        if(!$this->validateIdentity($id)) {
//            return $this->redirect(['ticket/']);
//        }
//
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Ticket model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::find()->ofId($id)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionReply($id)
    {
//        if(!$this->validateIdentity($id)) {
//            return $this->redirect(['ticket/']);
//        }

        $comment_model = new Comment();
        $comment_model->ticket_id = $id;

        if ($comment_model->load(Yii::$app->request->post()) && $comment_model->save()) {
            $comment_model->asd = UploadedFile::getInstance($comment_model,'asd');
            if($comment_model->asd) {
                $comment_model->upload();
                $comment_model->save();

            }
            $ticket_model = $this->findModel($id);
            $ticket_model->is_open = true;
            $ticket_model->save();

            return $this->redirect(['view', 'id' => $comment_model->ticket_id]);
        }

        return $this->render('/comment/create', [
            'comment_model' => $comment_model,
        ]);
    }

//    /** evaulates if user has premission to access the page
//     * @param integer $id requested parameter
//     * @return bool
//     */
//    public function validateIdentity($id)
//    {
//        return (!Yii::$app->user->isGuest && $this->findModel($id)->user_id == Yii::$app->user->getId());
//    }


}
