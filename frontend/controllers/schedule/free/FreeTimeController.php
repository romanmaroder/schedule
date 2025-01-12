<?php


namespace frontend\controllers\schedule\free;



use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\FreeTime;
use core\repositories\NotFoundException;
use core\useCases\manage\Schedule\FreeTimeManageService;
use yii\web\Controller;
use yii\web\Response;

class FreeTimeController extends Controller
{

    public function __construct(
        $id,
        $module,
        private FreeTimeManageService $freeTime,
        private readonly Calendar $calendar,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }



    public function actionFree()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->calendar->getFree();
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

    protected function findModel($id): FreeTime
    {
        if (($model = FreeTime::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}