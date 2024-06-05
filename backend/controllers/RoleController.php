<?php


namespace backend\controllers;


use backend\forms\RoleSearch;
use core\entities\User\Role;
use core\forms\manage\User\Role\RoleForm;
use core\services\manage\RoleServiceManager;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RoleController extends Controller
{
    private RoleServiceManager $service;
    public function __construct($id, $module, RoleServiceManager $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'role' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new RoleForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $role = $this->service->create($form);
                return $this->redirect(['view','id'=>$role->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $role= $this->findModel($id);
        $form = new RoleForm($role);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($role->id, $form);
                return $this->redirect(['view', 'id' => $role->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'role'=>$role,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Role::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}