<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\forms\CompositeForm;

/**
 * @property AdditionalForm $additional
 * @property MasterForm $master
 */
class FreeTimeCreateForm extends CompositeForm
{
    public $start;
    public $end;
    public $notice;
    public $status;
    public $color;

    public function __construct($config = [])
    {
        $this->additional = new AdditionalForm();
        $this->master = new MasterForm();
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['status'], 'integer'],
            [['start', 'end'], 'required'],
            [['notice', 'color'],'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['additional','master'];
    }
}