<?php


/* @var $this \yii\web\View */

/* @var $user \core\entities\User\Employee\Employee*/
/* @var $text */
/* @var $icon*/


?>
<? if(is_array($user)):?>
            <span class="holiday"><?=$text?></span>&nbsp;&nbsp;
            <span><i class="<?=$icon?>" style="color: #FFD43B;"></i></span>
    <? foreach ($user as $item):?>
        <? if ($item->isBirthday()): ?>
            <p> <?=$item->getFullName()?></p>
        <? endif; ?>
    <? endforeach;?>
<?else:?>
<? if ($user->isBirthday()): ?>
    <span class="holiday"><?=$text?></span>
    <span><i class="<?=$icon?>" style="color: #FFD43B;"></i></span><br>

    <? endif; ?>
<?endif;?>