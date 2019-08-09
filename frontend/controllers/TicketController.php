<?php
namespace frontend\controllers;

use common\models\Comment;
use common\models\Ticket;
use Yii;
use frontend\models\TicketSearch;
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
        $ticketModel = new Ticket();
        $commentModel = new Comment();

        if ($ticketModel->load(Yii::$app->request->post()) && $ticketModel->save()) {
            $commentModel->ticket_id = $ticketModel->id;

            if ($commentModel->load(Yii::$app->request->post()) && $commentModel->save()) {
                $commentModel->picture = UploadedFile::getInstance($commentModel,'picture');

                if ($commentModel->picture) {
                    $commentModel->upload();
                    $commentModel->save();
                }
                return $this->redirect(['view', 'id' => $ticketModel->id]);
            }
        }
        return $this->render('create', [
            'ticketModel' => $ticketModel,
            'commentModel' => $commentModel,
        ]);
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
        if (($model = Ticket::find()->ofId($id)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Makes comments for the ticket. Generates a new Comment, sets the key for the ticket.
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionReply($id)
    {
        $commentModel = new Comment();
        $commentModel->ticket_id = $id;

        if ($commentModel->load(Yii::$app->request->post()) && $commentModel->save()) {
            $commentModel->picture = UploadedFile::getInstance($commentModel,'picture');

            if($commentModel->picture) {
                $commentModel->upload();
            }
            $ticket_model = $this->findModel($id);
            $ticket_model->is_open = true;

            if ($commentModel->save() && $ticket_model->save()) {
                Yii::$app->session->setFlash('success','comment was created');
                return $this->redirect(['view', 'id' => $commentModel->ticket_id]);
            }
            Yii::$app->session->setFlash('error','Problem during reply');
            return $this->redirect('../index');
        }

        return $this->render('/comment/create', [
            'commentModel' => $commentModel,
        ]);
    }
}
