<?php


namespace core\services\messengers;


use core\services\messengers\interfaces\RenderInterface;
/**
 * Class RenderButton
 *
 * Button to hide a group of messenger buttons
 * Implementation example
 * @example
 * <div class="col-auto">
        <?= $messengers->build('sms',FlagsTemplates::SMS)->buildTrigger()->render()?>
 * </div>
 *       <div class="col-auto mb-2" id="<?=FlagsTemplates::GROUP_SMS?>">
            <?php
            echo $messengers->build('sms', FlagsTemplates::ADDRESS,$model)->buildRender()->render();
            echo $messengers->build('sms', FlagsTemplates::PRICE, $model)->buildRender()->render();
            echo $messengers->build('sms', FlagsTemplates::TOTAL_PRICE, $model)->buildRender()->render();
            echo $messengers->build('sms', FlagsTemplates::QUESTION, $model)->buildRender()->render();
            echo $messengers->build('sms', FlagsTemplates::REMAINDER, $model)->buildRender()->render();
            ?>
 *       </div>
 * <script>
        $('idGroup').addClass('d-none');
        $('idButton').on("click", function() {
            $('idGroup').animate({width: 'toggle'}).removeClass('d-none').css('display', 'flex');
        })
 * </script>
 *
*/
class RenderButton implements RenderInterface
{
    public $icon;
    public $flag;

    /**
     * RenderButton constructor.
     * @param $icon
     * @param $flag
     */
    public function __construct($icon, $flag)
    {
        $this->icon = $icon;
        $this->flag = $flag;
    }

    public function render()
    {
        return $this->button();
    }

    private function button(): string
    {
        $options = [
            'class' => 'btn btn-info btn-sm d-inline-block mr-1',
            'id' => $this->flag,
        ];
       return '<button class="'.$options['class'].'" id="'.$options['id'].'">'.$this->icon.'</button>';
    }

}