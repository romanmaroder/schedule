<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\EventSearch;
use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\Event;
use core\forms\manage\Schedule\Event\EventCopyForm;
use core\forms\manage\Schedule\Event\EventCreateForm;
use core\forms\manage\Schedule\Event\EventEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\repositories\NotFoundException;
use core\repositories\PriceRepository;
use core\services\bots\classes\Bot;
use core\services\bots\classes\telegram\TelegramBot;
use core\useCases\manage\Schedule\EventManageService;
use core\useCases\Schedule\CartService;
use core\useCases\Schedule\CartWithParamsService;
use core\useCases\Schedule\RequestService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class EventController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly EventManageService $service,
        private readonly Calendar $calendar,
        private readonly CartService $cart,
        private readonly EmployeeReadRepository $employees,
        private readonly PriceRepository $prices,
        private readonly RequestService $requestService,
        private readonly CartWithParamsService $serviceWithParams,
        private readonly EventReadRepository $repository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
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
            /*[
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600,
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => [Event::CACHE_KEY],
                ]
            ]*/
        ];
    }

    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search($this->request());
        $this->serviceWithParams->setParams($this->request());
        $cart = $this->serviceWithParams->getCart();

        return $this->render(
            'index',
            [
                //'searchModel' => $searchModel,
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
            Yii::$app->session->setFlash('msg', Yii::t('schedule/event','TOOLS READY'));
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
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event','Copied'));
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
        return $this->redirect(['index']);
    }

    public function actionUnpay($id)
    {
        $this->service->unpay($id);
        return $this->redirect(['index']);
    }

    public function actionCash($id)
    {
        $this->service->cash($id);
        return $this->redirect(['index']);
    }

    public function actionCard($id)
    {
        $this->service->card($id);
        return $this->redirect(['index']);
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
    private function request(): array
    {
        return $this->requestService->dataRangeParams('from_date', 'to_date');
    }
}