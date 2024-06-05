<?php


namespace frontend\controllers\cabinet;


use core\forms\user\ProfileEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
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
    public $totalLessonCount;
    public $todayLessonCount;
    public $user;
    public $employee;

    private $events;
    private $users;
    private $employees;
    private $education;
    private $profile;

    private EmployeeManageService $employeeService;

    public function __construct(
        $id,
        $module,
        EventReadRepository $events,
        UserReadRepository $users,
        EmployeeReadRepository $employees,
        EducationReadRepository $education,
        EmployeeManageService $employeeManageService,
        ProfileService $profile,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->events = $events;
        $this->users = $users;
        $this->employees = $employees;
        $this->education = $education;
        $this->employeeService = $employeeManageService;
        $this->totalCount = $this->events->getEventsCount(\Yii::$app->user->getId());
        $this->todayCount = $this->events->getEventsCountToday(\Yii::$app->user->getId());

        $this->totalLessonCount = $this->education->getLessonCount(\Yii::$app->user->getId());
        $this->todayLessonCount = $this->education->getLessonCountToday(\Yii::$app->user->getId());

        $this->user = $this->users->find(\Yii::$app->user->getId());
        if ($this->user) {
            $this->employee = $this->employees->find($this->user->employee);
        }
        $this->profile = $profile;
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
        $events = $this->events->getAllDayById($this->employee->user_id);

        $educations = $this->education->getLessonDayById($this->user->id);

        return $this->render(
            'timeline',
            [
                'employee' => $this->employee,
                'user' => $this->user,
                'events' => $events,
                'educations' => $educations,
            ]
        );
    }


    public function actionProfile()
    {
        $form = new ProfileEditForm($this->employee);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->profile->edit($this->employee->id, $form);
                return $this->redirect(['cabinet/default/profile',]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->render(
            'profile',
            [
                'employee' => $this->employee,
                'user' => $this->user,
                'model' => $form,
            ]
        );
    }

}