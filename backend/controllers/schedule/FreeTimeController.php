<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\FreeTimeSearch;
use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\FreeTime;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeCreateForm;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeEditForm;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeCopyForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\repositories\NotFoundException;
use core\services\manage\Schedule\FreeTimeManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class FreeTimeController extends Controller
{

    private FreeTimeManageService $freeTime;
    private Calendar $calendar;
    private EmployeeReadRepository $employees;

    public function __construct(
        $id,
        $module,
        FreeTimeManageService $freeTime,
        Calendar $calendar,
        EmployeeReadRepository $employees,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->freeTime = $freeTime;
        $this->calendar = $calendar;
        $this->employees = $employees;
    }

    public function behaviors(): array
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
        $searchModel = new FreeTimeSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }


    public function actionFree()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->calendar->getFree();
    }



    public function actionView($id)
    {

        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    public function actionCreate()
    {
        $form = new FreeTimeCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $free = $this->freeTime->create($form);
                return $this->redirect(['view', 'id' => $free->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'create',
            [
                'model' => $form,
            ]
        );
    }

    public function actionUpdate($id)
    {
        $free = $this->findModel($id);

        $form = new FreeTimeEditForm($free);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->freeTime->edit($free->id, $form);
                return $this->redirect(['view', 'id' => $free->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render(
            'update',
            [
                'model' => $form,
                'free' => $free,
            ]
        );
    }

    public function actionCopy($id)
    {
        $free = $this->findModel($id);

        $form = new FreeTimeCopyForm($free);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->freeTime->copy($form);
                Yii::$app->session->setFlash('msg', "The entry " . $free->master->username ." copied.");
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'copy',
            [
                'model' => $form,
                'free' => $free,
            ]
        );
    }


    /*public function actionCheck($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $employee = $this->employees->findEmployee($id);

        $hours = $employee->schedule->disabledHours($employee->schedule->hoursWork);
        $weekends = $employee->schedule->weekends;

        return [
            'hours' => $hours,
            'weekends' => $weekends
        ];
    }*/

    public function actionDelete($id)
    {
        try {
            $this->freeTime->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id): FreeTime
    {
        if (($model = FreeTime::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}