<?php


namespace backend\widgets\birthday;


use backend\widgets\birthday\assets\BirthdayAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class BirthdayWidget extends Widget
{
    /**
     * @var $user - users whose birthday is specified
     * @var $text string - congratulation text
     * @var $icon string - your own icon for congratulations
     * @var $myClass string - your own block wrapper class
     *
     */

    public $user;
    public $text;
    public $icon;
    public $myClass;

    private $_user;

    public function __construct(
        $user,
        $myClass,
        $text = 'HAPPY BIRTHDAY',
        $icon = 'fas fa-birthday-cake',
        $config = []
    ) {
        $this->user = $user;
        $this->text = $text;
        $this->icon = $icon;
        $this->myClass = $myClass;

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
            $this->_user = $this->user;
        }


    }

    public function run(): string
    {
        BirthdayAsset::register($this->view);
        return $this->render(
            'birthday',
            [
                'user' => $this->_user,
                'text' => $this->text,
                'icon' => $this->icon,
                'myClass' => $this->myClass,
            ]
        );
    }
}