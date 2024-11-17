<?php


namespace core\services\messengers\sms;


use core\services\messengers\interfaces\RenderInterface;

class RenderSms implements RenderInterface
{
    public $icon;
    public $message;
    public $title;
    public $data;
    public $_os;
    public $_href = 'sms:';

    public function __construct($icon, $message, $title, $data)
    {
        $this->icon = $icon;
        $this->message = $message;
        $this->title = $title;
        $this->data = $data;
        $this->_os = new OperatingSystemDefinition();
    }

    public function render()
    {
        return $this->smsLink();
    }

    private function smsLink(): string
    {
        if ($this->data->client->phone) {
            $options = [
                'class' => 'btn btn-info btn-sm d-inline-block mr-1',
                'href' => $this->_href . $this->data->client->phone . $this->getOs() .
                    $this->message,
                'title' => $this->title,
            ];
            return '<a href="' . $options['href'] . '" class="' . $options['class'] . '" title="' . $options['title'] . '"">' . $this->icon . '</a>';
        }
        return '';
    }

    private function getOs(): string
    {
        return $this->_os->checkOS();
    }
}