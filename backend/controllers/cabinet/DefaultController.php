<?php


namespace backend\controllers\cabinet;


use core\forms\user\ProfileEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\readModels\Schedule\FreeTimeReadRepository;
use core\readModels\User\UserReadRepository;
use core\services\manage\EmployeeManageService;
use core\useCases\cabinet\ProfileService;
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
    private $free;
    private $profile;

    private EmployeeManageService $employeeService;

    public function __construct(
        $id,
        $module,
        EventReadRepository $events,
        UserReadRepository $users,
        EmployeeReadRepository $employee,
        EducationReadRepository $education,
        FreeTimeReadRepository $free,
        EmployeeManageService $employeeManageService,
        ProfileService $profile,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->events = $events;
        $this->users = $users;
        $this->employee = $employee;
        $this->education = $education;
        $this->free = $free;
        $this->profile = $profile;
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
        $employee = $this->employee->findEmployee($this->user->id);

        $events = $this->events->getAllDayById($this->user->id);

        $educations = $this->education->getLessonDayById($this->user->id);

        $free = $this->free->getAllDayById($employee->user_id);


        return $this->render(
            'timeline',
            [
                'employee' => $employee,
                'user' => $this->user,
                'events' => $events,
                'educations'=>$educations,
                'free'=>$free
            ]
        );
    }

    public function actionProfile()
    {
        $employee = $this->employee->findEmployee($this->user->id);

        $form = new ProfileEditForm($employee);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->profile->edit($employee->id, $form);
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