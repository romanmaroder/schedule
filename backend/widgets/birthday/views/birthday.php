<?php


/* @var $this \yii\web\View */
/* @var $user \core\entities\User\Employee\Employee */
/* @var $text */
/* @var $icon */
/* @var $myClass */
?>

<?if ($user != null): ?>
    <div class="<?= $myClass ?>">
        <span class="holiday"><?= $text ?></span>&nbsp;&nbsp;
        <span><i class="holiday <?= $icon ?>"></i></span>
        <?
        if (is_array($user)): ?>
            <?
            foreach ($user as $item): ?>
                <?
                if ($item != null): ?>
                    <p class="text-warning"> <?= $item->getFullName() ?></p>
                <?
                endif; ?>
            <?
            endforeach; ?>
        <?
        endif; ?>
    </div>
<? endif; ?>
