<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\Role\RoleForm */

$this->title = Yii::t('role','Create Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('role','Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>