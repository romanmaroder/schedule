<?php


namespace backend\widgets\birthday;


use backend\widgets\birthday\assets\BirthdayAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class BirthdayWidget extends Widget
{
    /**
     * @param $user
     * @param string|null $myClass
     * @param string|null $text
     * @param string|null $icon
     * @param $_user
     * @param array $config
     */
    public function __construct(
        private $_user,
        public $user,
        public string|null $myClass,
        public string|null $text = 'HAPPY BIRTHDAY',
        public string|null $icon = 'fas fa-birthday-cake',
        array $config = []
    ) {
        parent::__construct($config);
    }

    public function init(): void
    {
        if (is_array($this->user)) {
            $this->_user = array_filter(
                ArrayHelper::map(
                    $this->user,
                    'id',
                    function ($item) {
                        if ($item->isBirthday()) {
                            return $item;
                        }
                        return null;
                    }
                ),
                fn($item) => !is_null($item)
            );
        } elseif ($this->user?->isBirthday()) {
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