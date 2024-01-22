<?php


namespace frontend\controllers\cabinet;


use schedule\readModels\Employee\EmployeeReadRepository;
use schedule\readModels\User\UserReadRepository;
use yii\web\Controller;

class ProfileController extends Controller
{
    public $layout= 'cabinet';

    private EmployeeReadRepository $repository;
    private UserReadRepository $user;

    public function __construct($id, $module, EmployeeReadRepository $repository, UserReadRepository $user, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->user = $user;
    }

    public function actionIndex()
    {
        $user = $this->user->find(\Yii::$app->user->getId());
        $employee = $this->repository->find($user->employee);

        return $this->render('index',[
            'employee'=> $employee,
            'user'=>$user,
        ]);
    }
}