<?php


namespace backend\controllers\schedule\api;


use core\entities\Schedule\Event\Event;
use core\forms\manage\Schedule\Event\EventCopyForm;
use core\forms\manage\Schedule\Event\EventCreateForm;
use core\forms\manage\Schedule\Event\EventEditForm;
use core\forms\manage\Schedule\Event\ToolsEditForm;
use core\helpers\BotLogger;
use core\readModels\Schedule\EventReadRepository;
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
    public function __construct(
        $id,
        $module,
        private readonly EventManageService $service,
        private readonly EventReadRepository $repository,
        private readonly CartService $cart,
        private readonly SmsSender $sms,
        private readonly MessengerFactory $messengers,
        private readonly PriceRepository $prices,
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
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event', 'Saved'));
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
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event', 'Saved'));
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

    public function actionHistory($id)
    {
        return $this->render(
            'history',
            [
                'model' => $this->repository->findClientEvents($id),
            ]
        );
    }

    public function actionTools($id)
    {

        $event = $this->findModel($id);

        $form = new ToolsEditForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->tools($event->id, $form);
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event', 'Saved'));
                return $this->redirect('/calendar');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax(
            'tools',
            [
                'model' => $form,
                'event' => $event,
            ]
        );
    }

    public function actionCopy($id)
    {
        $event = $this->findModel($id);

        $form = new EventCopyForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->copy($form, $event);
                Yii::$app->session->setFlash('msg', Yii::t('schedule/event', 'Copied'));
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
            $this->service->dragAndResize($event);
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