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
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
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

    public function actionCalendar()
    {
        $events = $this->calendar->getEvents();
        $education = $this->calendar->getEducations();
        return $this->render(
            'calendar',
            [
                'events'=>$events,
                'education'=>$education
            ]
        );
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

    public function actionViewAjax($id)
    {

        return $this->renderAjax(
            '_view',
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

    public function actionCreateAjax($start = null, $end = null)
    {
        $form = new EventCreateForm();
        $form->start = $start;
        $form->end = $end;

        if ($form->load(Yii::$app->request->post())) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('msg', "Запись " . $form->start . '-' . $form->end . " сохранена");
                return $this->redirect('/schedule/event/calendar');
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

    public function actionUpdateAjax($id)
    {
        $event = $this->findModel($id);

        $form = new EventEditForm($event);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($event->id, $form);
                Yii::$app->session->setFlash('msg', "Запись " . $form->start . '-' . $form->end . " сохранена");
                return $this->redirect('/schedule/event/calendar');
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