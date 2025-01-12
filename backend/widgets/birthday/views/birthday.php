<?php


/* @var $this \yii\web\View */
/* @var $user \core\entities\User\Employee\Employee */
/* @var $text */
/* @var $icon */
/* @var $myClass */
?>

<?php
if ($user != null): ?>
    <div class="<?= $myClass ?>">
        <span class="holiday"><?= $text ?></span>
        <span><i class="holiday <?= $icon ?>"></i></span>
        <?php
        if (is_array($user)): ?>
            <?php
            foreach ($user as $item): ?>
                <?php
                if ($item != null): ?>
                    <p class="text-warning"> <?= $item->getFullName() ?></p>
                <?php
                endif; ?>
            <?php
            endforeach; ?>
        <?php
        endif; ?>
    </div>
<?php
endif; ?>
