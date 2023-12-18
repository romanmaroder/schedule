<?php


namespace backend\controllers\schedule\api;


use schedule\entities\Schedule\Event\Calendar\Calendar;
use schedule\entities\Schedule\Event\Education;
use schedule\forms\manage\Schedule\Event\EducationCreateForm;
use schedule\forms\manage\Schedule\Event\EducationEditForm;
use schedule\repositories\NotFoundException;
use schedule\services\manage\Schedule\EducationManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class EducationApiController extends Controller
{
    private EducationManageService $service;
    private Calendar $calendar;

    public function __construct($id, $module, EducationManageService $service, Calendar $calendar, $config = [])
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
        $form = new EducationCreateForm();
        $form->start = $start;
        $form->end = $end;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('msg', "Запись " . $form->start . '-' . $form->end . " сохранена");
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
        $education = $this->findModel($id);

        $form = new EducationEditForm($education);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($education->id, $form);
                Yii::$app->session->setFlash('msg', "Lesson " . $form->start . '-' . $form->end . " saved");
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
            ]
        );
    }

    public function actionDraggingResizing($id, $start, $end): Education
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $education = $this->findModel($id);

        $education->start = date('Y-m-d H:i', strtotime($start));
        $education->end = date('Y-m-d H:i', strtotime($end));

        $this->service->save($education);
        return $education;
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

    protected function findModel($id): Education
    {
        if (($model = Education::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}