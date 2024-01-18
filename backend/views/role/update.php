<?php



/* @var $this \yii\web\View */
/* @var $model \schedule\forms\manage\User\Role\RoleForm */
/* @var $role null|\schedule\entities\User\Role */

$this->title = 'Update Role: ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $role->name, 'url' => ['view', 'id' => $role->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="role-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>