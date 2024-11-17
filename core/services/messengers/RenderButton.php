<?php


namespace core\services\messengers;


use core\services\messengers\interfaces\RenderInterface;

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