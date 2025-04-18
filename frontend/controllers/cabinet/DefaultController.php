<?php


namespace frontend\controllers\cabinet;


use core\forms\user\ProfileEditForm;
use core\readModels\Employee\EmployeeReadRepository;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\readModels\Schedule\FreeTimeReadRepository;
use core\readModels\Shop\ProductReadRepository;
use core\readModels\User\UserReadRepository;
use core\useCases\cabinet\WishlistService;
use core\useCases\manage\EmployeeManageService;
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

//    private $wishList;

    public function __construct(
        $id,
        $module,
        private EventReadRepository $events,
        private UserReadRepository $users,
        private EmployeeReadRepository $employees,
        private EducationReadRepository $education,
        private FreeTimeReadRepository $free,
        private EmployeeManageService $employeeManageService,
        private ProfileService $profile,
//        WishlistService $wishList,
        private ProductReadRepository $products,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->totalCount = $this->events->getEventsCount(\Yii::$app->user->getId());
        $this->todayCount = $this->events->getEventsCountToday(\Yii::$app->user->getId());

        $this->totalLessonCount = $this->education->getLessonCount(\Yii::$app->user->getId());
        $this->todayLessonCount = $this->education->getLessonCountToday(\Yii::$app->user->getId());

        $this->user = $this->users->find(\Yii::$app->user->getId());
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
                'pagination' => false,

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
        $employee = $this->employees->findEmployee($this->user->id);

        $events = $this->events->getAllDayById($this->user->id);

        $educations = $this->education->getLessonDayById($this->user->id);

        $free = $this->free->getAllDayById($this->user->id);

        return $this->render(
            'timeline',
            [
                'employee' => $employee,
                'events' => $events,
                'educations' => $educations,
                'free'=>$free
            ]
        );
    }


    public function actionProfile()
    {
        $employee = $this->employees->findEmployee($this->user->id);

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