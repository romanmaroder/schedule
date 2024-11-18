<?php


namespace core\services\messengers;


use core\services\messengers\interfaces\RenderInterface;

class TriggerButton implements RenderInterface
{
    public $buildIcon;
    public $flag;

    /**
     * TriggerButton constructor.
     * @param  $buildIcon
     * @param $flag
     */
    public function __construct( $buildIcon, $flag)
    {
        $this->buildIcon = $buildIcon;
        $this->flag = $flag;
    }

    public function render()
    {
        $options = [
            'class' => 'btn btn-info btn-sm d-inline-block mr-1',
            'id' => $this->flag,

        ];
        return '<button class="'.$options['class'].'" id="'.$options['id'].'">'.$this->buildIcon.'</button>';
    }
}