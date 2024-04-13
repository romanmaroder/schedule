<?php


namespace backend\controllers;


use backend\forms\EmployeeSearch;
use schedule\entities\User\Employee\Employee;
use schedule\forms\manage\User\Employee\EmployeeCreateForm;
use schedule\forms\manage\User\Employee\EmployeeEditForm;
use schedule\forms\manage\User\Employee\EmployeeExistCreateForm;
use schedule\services\manage\EmployeeManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EmployeeController extends Controller
{
    private $service;

    public function __construct($id, $module, EmployeeManageService $service, $config = [])
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
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new EmployeeCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->attach($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionExistingUser()
    {
        $form = new EmployeeExistCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create-exist', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $employee = $this->findModel($id);
        $form = new EmployeeEditForm($employee);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($employee->id, $form);
                return $this->redirect(['view', 'id' => $employee->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'employee' => $employee,
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
        if (($model = Employee::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}