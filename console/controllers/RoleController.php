<?php


namespace console\controllers;


use core\entities\User\User;
use core\services\manage\UserManageService;
use Exception;
use core\services\manage\EmployeeManageService;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class RoleController extends Controller
{
    private $service;

    public function __construct($id, $module, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Adds role to user
     */
    public function actionAssign(): void
    {
        $phone = $this->prompt('Phone employee: +X (XXX) XXX-XX-XX', ['required' => true]);
        $user= $this->findModel($phone);
        $role = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $this->service->assignRole($user->id, $role);
        $this->stdout('Done!' . PHP_EOL);
    }

    private function findModel($phone): User
    {
        if (!$model = User::findOne(['phone' => $phone])) {
            throw new Exception('Employee is not found');
        }
        return $model;
    }
}