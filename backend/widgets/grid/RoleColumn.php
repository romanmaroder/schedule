<?php


namespace backend\widgets\grid;


use core\entities\Enums\UserRolesEnum;
use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\rbac\Item;

class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = Yii::$app->authManager->getRolesByUser($model->user_id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(fn (Item $role) => $this->getRoleLabel($role), $roles));
    }

    private function getRoleLabel(Item $role): string
    {
        $class= UserRolesEnum::getBadge($role->name);
        return Html::tag('span', Html::encode($role->name), ['class' =>$class]);
    }
}