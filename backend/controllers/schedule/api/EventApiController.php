<?php


namespace backend\controllers\schedule\api;


use core\entities\Schedule\Event\Event;
use core\forms\manage\Schedule\Event\EventCopyForm;
use core\forms\manage\Schedule\Event\EventCreateForm;
use core\forms\manage\Schedule\Event\EventEditForm;
use core\helpers\BotLogger;
use core\repositories\NotFoundException;
use core\repositories\PriceRepository;
use core\services\messengers\MessengerFactory;
use core\services\sms\SmsSender;
use core\useCases\manage\Schedule\EventManageService;
use core\useCases\Schedule\CartService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class EventApiController extends Controller
{
    private EventManageService $service;
    private CartService $cart;
    private SmsSender $sms;
    private MessengerFactory $messengers;
    private PriceRepository $prices;

    public function __construct(
        $id,
        $module,
        EventManageService $service,
        CartService $cart,
        SmsSender $sms,
        MessengerFactory $messengers,
        PriceRepository $prices,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->cart = $cart;
        $this->sms = $sms;
        $this->messengers = $messengers;
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

    public function actionView($id)
    {
        $cart = $this->cart->getCart();
        return $this->renderAjax(
            'view',
            [
                'model' => $this->findModel($id),
                'cart' => $cart,
                'sms' => $this->sms,
                'messengers' => $this->messengers,
            ]
        );
    }

    public function actionCreate($start = null, $end = null)
    {
        $form = new EventCreateForm();
        $form->start = $start;
        $form->end = $end;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event','Saved'));
                return $this->redirect('/schedule/calendar/calendar');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->renderAjax(
            'create',
            [
                'model' => $form,
            ]
        );
    }

    public function actionUpdate($id)
    {
        $event = $this->findModel($id);

        $form = new EventEditForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($event->id, $form);
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event','Saved'));
                return $this->redirect('/schedule/calendar/calendar');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax(
            'update',
            [
                'model' => $form,
                'event' => $event,
            ]
        );
    }

    public function actionTools($id)
    {
        $event = $this->findModel($id);
        try {
            $this->service->tools($event->id);
            Yii::$app->session->setFlash('msg', Yii::t('schedule/event','TOOLS READY'));
            return $this->redirect('/schedule/calendar/calendar');
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
                return $this->redirect('/schedule/calendar/calendar');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax(
            'copy',
            [
                'model' => $form,
                'event' => $event,
            ]
        );
    }


    public function actionDraggingResizing($id, $start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $event = $this->findModel($id);

        $event->start = date('Y-m-d H:i', strtotime($start));
        $event->end = date('Y-m-d H:i', strtotime($end));

        /* Receiving errors from the bot */
        if ($event->client->isChatId()) {
            $log = Yii::getAlias('@core/services/bots/') . 'log.txt';
            $error = BotLogger::getLog($log);
        }
        /* bot error */

        try {
            $this->service->save($event);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return [
            'event' => $event,
            'content' => [
                'start' => Yii::t('schedule/event', 'Start'),
                'end' => Yii::t('schedule/event', 'End'),
                'resize' => Yii::t('schedule/event', 'resize'),
                'drop' => Yii::t('schedule/event', 'drop'),
            ],
            'error' => $error ?? null,
        ];
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/schedule/calendar/calendar']);
    }

    protected function findModel($id): Event
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}