<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\EducationSearch;
use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\Education;
use core\forms\manage\Schedule\Event\EducationCreateForm;
use core\forms\manage\Schedule\Event\EducationEditForm;
use core\repositories\NotFoundException;
use core\useCases\manage\Schedule\EducationManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class EducationController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly EducationManageService $service,
        private readonly Calendar $calendar,
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

    public function actionIndex()
    {
        $searchModel = new EducationSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLessons()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->calendar->getEducations();
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
        $form = new EducationCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $education = $this->service->create($form);
                return $this->redirect(['view', 'id' => $education->id]);
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
        $education = $this->findModel($id);

        $form = new EducationEditForm($education);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($education->id, $form);
                return $this->redirect(['view', 'id' => $education->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render(
            'update',
            [
                'model' => $form,
                'education' => $education,
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
        return $this->redirect(['/core/education/index']);
    }

    protected function findModel($id): Education
    {
        if (($model = Education::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }

}