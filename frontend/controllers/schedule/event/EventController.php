<?php


namespace frontend\controllers\schedule\event;


use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\Event;
use core\repositories\NotFoundException;
use core\useCases\manage\Schedule\EventManageService;
use core\useCases\Schedule\CartService;
use yii\web\Controller;
use yii\web\Response;

class EventController extends Controller
{
   public function __construct($id, $module,
        private readonly EventManageService $service,
        private readonly Calendar $calendar,
        private readonly CartService $cart,$config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        /*echo '<pre>';
        $event = Event::find()->with(['services', 'master', 'client'])->andWhere(['id' => 5])->one();
        $a = null;
        $b=[];
        foreach ($event->services as $i => $service) {
            $a += (int)$service->price_new * 0.75 * 0.5;
            $b[]=(int)$service->price_new * 0.75;
        }
        var_dump($a);
        var_dump($b);*/
        //var_dump($event->services);
    }

    public function actionEvents()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->calendar->getEvents();
    }

    public function actionView($id)
    {
        $cart = $this->cart->getCart();
        return $this->renderAjax(
            'view',
            [
                'model' => $this->findModel($id),
                'cart' => $cart,
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