<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\Role\RoleForm */
/* @var $role null|\core\entities\User\Role */

$this->title = Yii::t('role','Update Role: ') . $role->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('role','Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $role->name, 'url' => ['view', 'id' => $role->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="role-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>