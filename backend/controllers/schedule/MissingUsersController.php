<?php


namespace backend\controllers\schedule;


use core\readModels\Schedule\EventReadRepository;
use core\readModels\User\UserReadRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class MissingUsersController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly UserReadRepository $users,
        private readonly EventReadRepository $events,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
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
        $users = $this->users->findMissed($this->events->findRecordsFromTodayDate());

        return $this->render(
            'missing',
            [
                'dataProvider' => $users
            ]
        );
    }
}