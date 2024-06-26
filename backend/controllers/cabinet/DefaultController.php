<?php


namespace backend\controllers\cabinet;


use core\forms\manage\User\Employee\EmployeeEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\readModels\User\UserReadRepository;
use core\services\manage\EmployeeManageService;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'cabinet';
    public $totalCount;
    public $todayCount;
    public $totalAllCount;
    public $totalLessonCount;
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

        $this->totalAllCount = $this->events->getAllEventsCount();
        $this->totalCount = $this->events->getEventsCount(\Yii::$app->user->getId());
        $this->todayCount = $this->events->getEventsCountToday(\Yii::$app->user->getId());

        $this->totalLessonCount = $this->education->getAllLessonCount();
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
        $event = $this->events->getAllWeekById($this->user->id);


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
                'user' => $this->user,
                'provider' => $provider,
            ]
        );
    }

    public function actionTimeline()
    {
        $employee = $this->employee->find($this->user->employee);

        $events = $this->events->getAllDayById($employee->user_id);

        $educations = $this->education->getLessonDayById($this->user->id);


        return $this->render(
            'timeline',
            [
                'employee' => $employee,
                'user' => $this->user,
                'events' => $events,
                'educations'=>$educations,
            ]
        );
    }

    public function actionProfile()
    {
        $employee = $this->employee->find($this->user->id);

        $form = new EmployeeEditForm($employee);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->employeeService->edit($employee->id, $form);
                return $this->redirect(['cabinet/default/profile',]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->render(
            'profile',
            [
                'employee' => $employee,
                'user' => $this->user,
                'model' => $form,
            ]
        );
    }
}