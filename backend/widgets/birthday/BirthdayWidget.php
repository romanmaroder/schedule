<?php


namespace backend\widgets\birthday;


use yii\base\InvalidConfigException;
use yii\base\Widget;

class BirthdayWidget extends Widget
{
    public $user;
    public $text;
    public $icon;

    public function __construct($user, $text = 'HAPPY BIRTHDAY', $icon = 'fas fa-birthday-cake', $config = [])
    {
        $this->user = $user;
        $this->text = $text;
        $this->icon = $icon;

        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->user) {
            throw new InvalidConfigException('Birthday not specified.');
        }
    }

    public function run(): string
    {
        return $this->render(
            'birthday',
            [
                'user' => $this->user,
                'text' => $this->text,
                'icon' => $this->icon,
            ]
        );
    }
}