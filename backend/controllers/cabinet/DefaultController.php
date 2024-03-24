<?php


namespace backend\controllers\cabinet;


use schedule\forms\manage\User\Employee\EmployeeEditForm;
use schedule\readModels\Employee\EmployeeReadRepository;
use schedule\readModels\Schedule\EducationReadRepository;
use schedule\readModels\Schedule\EventReadRepository;
use schedule\readModels\User\UserReadRepository;
use schedule\services\manage\EmployeeManageService;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'cabinet';
    public $totalCount;
    public $todayCount;
    public $user;

    private $events;
    private $users;
    private $employee;
    private $education;

    private EmployeeManageService $employeeService;

    public function __construct(
        $id,
        $module,
        EventReadRepository $events,
        UserReadRepository $users,
        EmployeeReadRepository $employee,
        EducationReadRepository $education,
        EmployeeManageService $employeeManageService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->events = $events;
        $this->users = $users;
        $this->employee = $employee;
        $this->education = $education;
        $this->employeeService = $employeeManageService;
        $this->totalCount = $this->events->getEventsCount(\Yii::$app->user->getId());
        $this->todayCount = $this->events->getEventsCountToday(\Yii::$app->user->getId());
        $this->user= $this->users->find(\Yii::$app->user->getId());
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = $this->users->find(\Yii::$app->user->getId());
        $event = $this->events->getAllWeekById($user->id);


        $provider = new ArrayDataProvider(
            [
                'allModels' => $event,
                'pagination' => [
                    'pageSize' => 10,
                ],

            ]
        );

        return $this->render(
            'index',
            [
                'user' => $user,
                'provider' => $provider,
            ]
        );
    }

    public function actionTimeline()
    {
        $user = $this->users->find(\Yii::$app->user->getId());

        $employee = $this->employee->find($user->employee);

        $events = $this->events->getAllDayById($employee->user_id);

        $educations = $this->education->getLessonDayById($user->id);


        return $this->render(
            'timeline',
            [
                'employee' => $employee,
                'user' => $user,
                'events' => $events,
                'educations'=>$educations,
            ]
        );
    }

    public function actionProfile()
    {
        $user = $this->users->find(\Yii::$app->user->getId());
        $employee = $this->employee->find($user->employee);

        $form = new EmployeeEditForm($employee);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->employeeService->edit($employee->id, $form);
                return $this->redirect(['cabinet/default/index',]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->render(
            'profile',
            [
                'employee' => $employee,
                'user' => $user,
                'model' => $form,
            ]
        );
    }
}