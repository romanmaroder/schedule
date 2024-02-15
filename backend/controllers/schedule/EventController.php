<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\EventSearch;
use schedule\entities\Schedule\Event\Calendar\Calendar;
use schedule\entities\Schedule\Event\Event;
use schedule\forms\manage\Schedule\Event\EventCreateForm;
use schedule\forms\manage\Schedule\Event\EventEditForm;
use schedule\repositories\NotFoundException;
use schedule\services\manage\Schedule\EventManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class EventController extends Controller
{

    private EventManageService $service;
    private Calendar $calendar;

    public function __construct($id, $module, EventManageService $service, Calendar $calendar, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
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

        $events = Event::find()->with(['services', 'employee', 'client'])->andWhere(['id' => 20])->all();
        $price = $events[0]->services[0]->price_new;
        $discount = $events[0]->client->discount;
        $rate = $events[0]->employee->rate->rate;

        $cost = $price * (1 - $discount/100);
        $salary = $cost *$rate;
        /* echo '<pre>';
         var_dump($events[0]->services[0]->price_new);
         var_dump($events[0]->employee->rate->rate);
         var_dump($cost);
         var_dump($salary);
         die();*/
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

        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
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
            ]
        );
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