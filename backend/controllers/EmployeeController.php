<?php


namespace backend\controllers;


use backend\forms\EmployeeSearch;
use core\entities\User\Employee\Employee;
use core\forms\manage\User\Employee\EmployeeCreateForm;
use core\forms\manage\User\Employee\EmployeeEditForm;
use core\forms\manage\User\Employee\EmployeeExistCreateForm;
use core\helpers\MultiPriceHelper;
use core\readModels\Employee\EmployeeReadRepository;
use core\useCases\manage\EmployeeManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EmployeeController extends Controller
{
    private $service;
    private EmployeeReadRepository $employees;

    public function __construct(
        $id,
        $module,
        EmployeeManageService $service,
        EmployeeReadRepository $employees,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->employees = $employees;
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


    public function actionPriceList($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        $employee = $this->employees->findEmployee($id);

        $results = array_map(
            function ($service) {
                $data['id'] = $service->id;
                $data['name'] = $service->name;
                $data['category'] = $service->category->id;
                $data['category_parent'] = $service->category->parent->id;
                $data['category_parent_name'] = $service->category->parent->name;

                return $data;
            },
            $employee->multiPrice->services
        );
        $out = MultiPriceHelper::renderPrice($results);
        return [
            'out' => $out
        ];
    }

    public function actionSchedule($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $employee = $this->employees->findEmployee($id);


        $hours = $employee->schedule->disabledHours($employee->schedule->hoursWork);
        $weekends = $employee->schedule->weekends;

        return [
            'hours' => $hours,
            'weekends' => $weekends,
        ];
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}