<?php


namespace core\services\messengers\telegram;


use core\services\messengers\interfaces\RenderInterface;

class RenderTelegram implements RenderInterface
{
    public $icon;
    public $message;
    public $title;
    public $data;
    public $_href = 'https://t.me/share/url?url=';
    /**
     * RenderTelegram constructor.
     * @param $icon
     * @param $message
     * @param $title
     * @param $data
     */
    public function __construct($icon, $message, $title, $data)
    {
        $this->icon = $icon;
        $this->message = $message;
        $this->title = $title;
        $this->data = $data;
    }

    public function render()
    {
        return $this->link();
    }

    private function link(): string
    {
            $options = [
                'class' => 'btn btn-info btn-sm d-inline-block mr-1',
                'href' => $this->_href . rawurlencode( $this->message),
                'title' => $this->title,
            ];
            return '<a href="' . $options['href'] . '" class="' . $options['class'] . '" title="' . $options['title'] . '"">' . $this->icon . '</a>';

    }
}
