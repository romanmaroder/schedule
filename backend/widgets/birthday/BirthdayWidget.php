<?php


namespace backend\widgets\birthday;


use yii\base\Widget;
use yii\helpers\ArrayHelper;

class BirthdayWidget extends Widget
{
    public $user;
    public $text;
    public $icon;

    public $_user;

    public function __construct($user, $text = 'HAPPY BIRTHDAY', $icon = 'fas fa-birthday-cake', $config = [])
    {
        $this->user = $user;
        $this->text = $text;
        $this->icon = $icon;

        parent::__construct($config);
    }

    public function init(): void
    {
        if (is_array($this->user)) {
            $this->_user = array_filter(ArrayHelper::map(
                $this->user,
                'id',
                function ($item) {
                    if ($item->isBirthday()) {
                        return $item ;
                    }
                }
            ), fn ($item) => !is_null($item));
        }elseif ($this->user->isBirthday()){
            $this->_user =$this->user;
        }


    }

    public function run(): string
    {
        return $this->render(
            'birthday',
            [
                'user' => $this->_user,
                'text' => $this->text,
                'icon' => $this->icon,
            ]
        );
    }
}