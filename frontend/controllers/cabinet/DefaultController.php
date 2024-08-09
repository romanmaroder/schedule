<?php


namespace frontend\controllers\cabinet;


use core\forms\user\ProfileEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\readModels\Schedule\FreeTimeReadRepository;
use core\readModels\Shop\ProductReadRepository;
use core\readModels\User\UserReadRepository;
use core\services\cabinet\WishlistService;
use core\services\manage\EmployeeManageService;
use core\useCases\cabinet\ProfileService;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
    private $free;
    private $profile;
//    private $wishList;
    private $products;

    private EmployeeManageService $employeeService;

    public function __construct(
        $id,
        $module,
        EventReadRepository $events,
        UserReadRepository $users,
        EmployeeReadRepository $employees,
        EducationReadRepository $education,
        FreeTimeReadRepository $free,
        EmployeeManageService $employeeManageService,
        ProfileService $profile,
//        WishlistService $wishList,
        ProductReadRepository $products,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->events = $events;
        $this->users = $users;
        $this->employees = $employees;
        $this->education = $education;
        $this->free = $free;
        $this->employeeService = $employeeManageService;
        $this->totalCount = $this->events->getEventsCount(\Yii::$app->user->getId());
        $this->todayCount = $this->events->getEventsCountToday(\Yii::$app->user->getId());

        $this->totalLessonCount = $this->education->getLessonCount(\Yii::$app->user->getId());
        $this->todayLessonCount = $this->education->getLessonCountToday(\Yii::$app->user->getId());

        $this->user = $this->users->find(\Yii::$app->user->getId());
        if ($this->user) {
            $this->employee = $this->employees->find($this->user->id);
        }
        $this->profile = $profile;
//        $this->wishList = $wishList;
        $this->products = $products;
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['POST'],
                    'delete' => ['POST'],
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
                'provider' => $provider,
            ]
        );
    }

    public function actionTimeline()
    {
        $events = $this->events->getAllDayById($this->employee->user_id);

        $educations = $this->education->getLessonDayById($this->user->id);

        $free = $this->free->getAllDayById($this->user->id);

        return $this->render(
            'timeline',
            [
                'events' => $events,
                'educations' => $educations,
                'free'=>$free
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
                'model' => $form,
            ]
        );
    }

    /*public function actionWishlist()
    {
        $dataProvider = $this->products->getWishList($this->user);

        return $this->render('wishlist', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * @param $id
     * @return mixed
     */
    /*public function actionWishlistAdd($id)
    {
        try {
            $this->wishList->add(Yii::$app->user->id, $id);
            Yii::$app->session->setFlash('success', 'Success!');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }*/

    /**
     * @param $id
     * @return mixed
     */
    /*public function actionWishlistDelete($id)
    {
        try {
            $this->wishList->remove(Yii::$app->user->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['wishlist']);
    }*/

}