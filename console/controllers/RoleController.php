<?php


namespace console\controllers;


use Exception;
use core\entities\User\Employee\Employee;
use core\services\manage\EmployeeManageService;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class RoleController extends Controller
{
    private $service;

    public function __construct($id, $module, EmployeeManageService $service, $config = [])
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
        $employee= $this->findModel($phone);
        $role = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $this->service->assignRole($employee->id, $role);
        $this->stdout('Done!' . PHP_EOL);
    }

    private function findModel($phone): Employee
    {
        if (!$model = Employee::findOne(['phone' => $phone])) {
            throw new Exception('Employee is not found');
        }
        return $model;
    }
}