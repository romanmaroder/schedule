<?php


namespace frontend\controllers\cabinet;


use schedule\forms\manage\User\Employee\EmployeeEditForm;
use schedule\readModels\Employee\EmployeeReadRepository;
use schedule\readModels\User\UserReadRepository;
use schedule\services\manage\EmployeeManageService;
use Yii;
use yii\web\Controller;

class ProfileController extends Controller
{
    public $layout = 'cabinet';

    private EmployeeReadRepository $repository;
    private UserReadRepository $user;
    private EmployeeManageService $service;

    public function __construct(
        $id,
        $module,
        EmployeeReadRepository $repository,
        UserReadRepository $user,
        EmployeeManageService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->user = $user;
        $this->service = $service;
    }

    public function actionIndex()
    {
        $user = $this->user->find(\Yii::$app->user->getId());
        $employee = $this->repository->find($user->employee);

        $form = new EmployeeEditForm($employee);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($employee->id, $form);
                return $this->redirect(['cabinet/default',]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->render(
            'index',
            [
                'employee' => $employee,
                'user' => $user,
                'model' => $form,
            ]
        );
    }

}