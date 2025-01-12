<?php


namespace backend\controllers\cabinet;


use core\forms\user\ProfileEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\readModels\Schedule\FreeTimeReadRepository;
use core\readModels\User\UserReadRepository;
use core\useCases\manage\EmployeeManageService;
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
    public function __construct(
        $id,
        $module,
        private readonly EventReadRepository $events,
        private readonly UserReadRepository $users,
        private readonly EmployeeReadRepository $employee,
        private readonly EducationReadRepository $education,
        private readonly FreeTimeReadRepository $free,
        private EmployeeManageService $employeeManageService,
        private readonly ProfileService $profile,
        $config = []
    ) {
        parent::__construct($id, $module, $config);

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
                'pagination' => false,
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

        $free = $this->free->getAllDayById($this->user->id);


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