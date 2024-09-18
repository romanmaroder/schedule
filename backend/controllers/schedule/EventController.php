<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\EventSearch;
use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\Event;
use core\forms\manage\Schedule\Event\EventCopyForm;
use core\forms\manage\Schedule\Event\EventCreateForm;
use core\forms\manage\Schedule\Event\EventEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\repositories\NotFoundException;
use core\repositories\PriceRepository;
use core\useCases\manage\Schedule\EventManageService;
use core\useCases\Schedule\CartService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class EventController extends Controller
{

    private EventManageService $service;
    private Calendar $calendar;
    private CartService $cart;
    private EmployeeReadRepository $employees;
    private PriceRepository $prices;

    public function __construct(
        $id,
        $module,
        EventManageService $service,
        Calendar $calendar,
        CartService $cart,
        EmployeeReadRepository $employees,
        PriceRepository $prices,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
        $this->cart = $cart;
        $this->employees = $employees;
        $this->prices = $prices;
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
        $cart = $this->cart->getCart();

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'cart'=>$cart,
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
        $price = $this->prices->getByValue($event->price);
        $event->price = $price->id;

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

    public function actionTools($id)
    {
        $event = $this->findModel($id);
        try {
            $this->service->tools($event->id);
            Yii::$app->session->setFlash('msg', "Tools are ready.");
            return $this->redirect(['view', 'id' => $event->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function actionCopy($id)
    {
        $event = $this->findModel($id);

        $form = new EventCopyForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->copy($form);
                Yii::$app->session->setFlash('msg', "The entry " . $event->client->username ." copied.");
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