<?php


namespace console\controllers;


use Exception;
use schedule\entities\User\Employee\Employee;
use schedule\services\manage\EmployeeManageService;
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
        $lastName = $this->prompt('Employee:', ['required' => true]);
        $employee= $this->findModel($lastName);
        $role = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $this->service->assignRole($employee->id, $role);
        $this->stdout('Done!' . PHP_EOL);
    }

    private function findModel($lastName): Employee
    {
        if (!$model = Employee::findOne(['last_name' => $lastName])) {
            throw new Exception('Employee is not found');
        }
        return $model;
    }
}