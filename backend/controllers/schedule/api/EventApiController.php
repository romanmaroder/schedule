<?php


namespace backend\controllers\schedule\api;


use schedule\entities\Schedule\Event\Event;
use schedule\forms\manage\Schedule\Event\EventCreateForm;
use schedule\forms\manage\Schedule\Event\EventEditForm;
use schedule\repositories\NotFoundException;
use schedule\services\manage\Schedule\EventManageService;
use schedule\services\schedule\CartService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class EventApiController extends Controller
{
    private EventManageService $service;
    private CartService $cart;

    public function __construct($id, $module, EventManageService $service,CartService $cart, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->cart = $cart;
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
                'cart'=>$cart,
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
                Yii::$app->session->setFlash('msg', "Event " . $form->start . '-' . $form->end . " saved.");
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
                Yii::$app->session->setFlash('msg', "Event " . $form->start . '-' . $form->end . " saved.");
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

    public function actionDraggingResizing($id, $start, $end): Event
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $event = $this->findModel($id);

        $event->start = date('Y-m-d H:i', strtotime($start));
        $event->end = date('Y-m-d H:i', strtotime($end));

        $this->service->save($event);
        return $event;
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