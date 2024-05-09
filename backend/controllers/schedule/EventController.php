<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\EventSearch;
use schedule\entities\Schedule\Event\Calendar\Calendar;
use schedule\entities\Schedule\Event\Event;
use schedule\forms\manage\Schedule\Event\EventCopyForm;
use schedule\forms\manage\Schedule\Event\EventCreateForm;
use schedule\forms\manage\Schedule\Event\EventEditForm;
use schedule\readModels\Employee\EmployeeReadRepository;
use schedule\repositories\NotFoundException;
use schedule\services\manage\Schedule\EventManageService;
use schedule\services\schedule\CartService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class EventController extends Controller
{

    private EventManageService $service;
    private Calendar $calendar;
    private CartService $cart;
    private EmployeeReadRepository $employees;

    public function __construct(
        $id,
        $module,
        EventManageService $service,
        Calendar $calendar,
        CartService $cart,
        EmployeeReadRepository $employees,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
        $this->cart = $cart;
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
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    public function actionEvents()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->calendar->getEvents();
    }

    public function actionView($id)
    {
       $cart = $this->cart->getCart();

        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
                'cart'=>$cart,
            ]
        );
    }

    public function actionCreate()
    {
        $form = new EventCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $event = $this->service->create($form);
                return $this->redirect(['view', 'id' => $event->id]);
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
        $event = $this->findModel($id);
        $cart = $this->cart->getCart();

        $form = new EventEditForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($event->id, $form);
                return $this->redirect(['view', 'id' => $event->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render(
            'update',
            [
                'model' => $form,
                'event' => $event,
                'cart' => $cart
            ]
        );
    }

    public function actionCopy($id)
    {
        $event = $this->findModel($id);

        $form = new EventCopyForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->copy($form);
                Yii::$app->session->setFlash('msg', "The entry " . $event->client->username ." copied.");
                return $this->redirect(['view', 'id' => $event->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render(
            'copy',
            [
                'model' => $form,
                'event' => $event,
            ]
        );
    }

    public function actionPay($id)
    {
        $this->service->pay($id);
        return $this->redirect('index');
    }

    public function actionUnpay($id)
    {
        $this->service->unpay($id);
        return $this->redirect('index');
    }

    public function actionCash($id)
    {
        $this->service->cash($id);
        return $this->redirect('index');
    }

    public function actionCard($id)
    {
        $this->service->card($id);
        return $this->redirect('index');
    }

    public function actionCheck($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $employee = $this->employees->findEmployee($id);

        $hours = $employee->schedule->disabledHours($employee->schedule->hoursWork);
        $weekends = $employee->schedule->weekends;

        return [
            'hours' => $hours,
            'weekends' => $weekends
        ];
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id): Event
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}