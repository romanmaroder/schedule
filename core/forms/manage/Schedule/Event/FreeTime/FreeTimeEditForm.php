<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\entities\Schedule\Event\FreeTime;
use core\forms\CompositeForm;

/**
 * @property AdditionalForm $additional
 * @property MasterForm $master
 */
class FreeTimeEditForm extends CompositeForm
{
    public $start;
    public $end;
    public $notice;
    private $_freeTime;

    public function __construct(FreeTime $freeTime, $config = [])
    {
        $this->master = new MasterForm($freeTime);
        $this->start = $freeTime->start;
        $this->end = $freeTime->end;
        $this->notice = $freeTime->notice;
        $this->additional = new AdditionalForm($freeTime);
        $this->_freeTime = $freeTime;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['start', 'end'], 'required'],
            ['notice', 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['additional','master'];
    }
}