<?php


namespace backend\controllers\schedule\api;


use core\entities\Schedule\Event\FreeTime;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeCopyForm;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeCreateForm;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeEditForm;
use core\repositories\NotFoundException;
use core\useCases\manage\Schedule\FreeTimeManageService;
use core\useCases\Schedule\CartService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FreeTimeApiController extends Controller
{
    private FreeTimeManageService $freeTime;
    private CartService $cart;

    public function __construct($id, $module, FreeTimeManageService $freeTime,CartService $cart, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->freeTime = $freeTime;
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
        return $this->renderAjax(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    public function actionCreate($start = null, $end = null)
    {
        $form = new FreeTimeCreateForm();
        $form->start = $start;
        $form->end = $end;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->freeTime->create($form);
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
        $free = $this->findModel($id);

        $form = new FreeTimeEditForm($free);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->freeTime->edit($free->id, $form);
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
                'free' => $free,
            ]
        );
    }

    public function actionCopy($id)
    {
        $free = $this->findModel($id);

        $form = new FreeTimeCopyForm($free);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->freeTime->copy($form);
                Yii::$app->session->setFlash('msg', "The entry " . $free->master->username ." copied.");
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
                'free' => $free,
            ]
        );
    }


    public function actionDraggingResizing($id, $start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $free = $this->findModel($id);

        $free->start = date('Y-m-d H:i', strtotime($start));
        $free->end = date('Y-m-d H:i', strtotime($end));

        $this->freeTime->save($free);
        return [
            'event' => $free,
            'content' => [
                'start' => Yii::t('schedule/event','Start'),
                'end' => Yii::t('schedule/event','End'),
                'resize' => Yii::t('schedule/event','resize'),
                'drop' => Yii::t('schedule/event','drop'),
            ]
        ];
    }

    public function actionDelete($id)
    {
        try {
            $this->freeTime->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/schedule/calendar/calendar']);
    }

    protected function findModel($id): FreeTime
    {
        if (($model = FreeTime::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}