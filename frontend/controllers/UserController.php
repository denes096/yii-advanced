<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use frontend\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UpdateUserForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!$this->validateIdentity($id)) {
            return $this->redirect(['site/index']);
        }

        $user = $this->findModel($id);

        $updateUserModel = new UpdateUserForm();
        $updateUserModel->fillFrom($user);

        if ($updateUserModel->load(Yii::$app->request->post()) && $updateUserModel->validate()) {
            $user = $updateUserModel->fillTo($user);
            if(!$user->save()){
                //TODO hibaüzenet
            } else {
                //TODO Siker
            }
            Yii::$app->session->setFlash('success','Your account has been modified successfully');
            return $this->redirect(['profile', 'id' => $user->id]);
        }

        return $this->render('update', [
            'updateUserModel' => $updateUserModel,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::find()->ofId($id)->one()) !== null) {
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
        if ($this->validateIdentity($id)) {
            $model = User::find()->ofId($id)->one();
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['site/index']);
    }

    /** evaulates if user has premission to access the page
     * @param integer $id requested parameter
     * @return bool
     */
    public function validateIdentity($id)
    {
        return (!Yii::$app->user->isGuest && $id == Yii::$app->user->getId());
    }
}
