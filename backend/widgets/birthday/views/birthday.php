<?php


/* @var $this \yii\web\View */

/* @var $user \core\entities\User\Employee\Employee */
/* @var $text */
/* @var $icon */

?>

<?if ($user != null): ?>
    <span class="holiday"><?= $text ?></span>&nbsp;&nbsp;
    <span><i class="<?= $icon ?>" style="color: #FFD43B;"></i></span>
    <? if (is_array($user)): ?>
        <? foreach ($user as $item): ?>
            <? if ($item != null): ?>
                <p class="text-warning"> <?= $item->getFullName() ?></p>
            <? endif; ?>
        <? endforeach; ?>
    <? endif; ?>
<? endif; ?>
