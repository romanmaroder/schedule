<?php


namespace frontend\controllers\schedule\event;


use schedule\entities\Schedule\Event\Calendar\Calendar;
use schedule\entities\Schedule\Event\Event;
use schedule\repositories\NotFoundException;
use schedule\services\manage\Schedule\EventManageService;
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

    public function actionIndex()
    {
        echo '<pre>';
        $event = Event::find()->with(['services', 'master', 'client'])->andWhere(['id' => 5])->one();
        $a = null;
        $b=[];
        foreach ($event->services as $i => $service) {
            $a += (int)$service->price_new * 0.75 * 0.5;
            $b[]=(int)$service->price_new * 0.75;
        }
        var_dump($a);
        var_dump($b);
        //var_dump($event->services);
    }

    public function actionEvents()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->calendar->getEvents();
    }

    public function actionView($id)
    {

        return $this->renderAjax(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    protected function findModel($id): Event
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }

}