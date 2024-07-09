<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\entities\Schedule\Event\FreeTime;
use core\forms\CompositeForm;

/**
 * @property AdditionalForm $additional
 * @property MasterForm $master
 */
class FreeTimeCopyForm extends CompositeForm
{
    public $id;
    public $start;
    public $end;
    public $notice;
    private $_freeTime;

    public function __construct(FreeTime $freeTime, $config = [])
    {
        $clone = $freeTime->copied();

        $this->master = new MasterForm($clone);
        $this->start = $clone->start;
        $this->end = $clone->end;
        $this->notice = $clone->notice;
        $this->additional = new AdditionalForm($clone);
        $this->_freeTime = $clone;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['start', 'end'], 'required'],
            [['notice'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['additional','master'];
    }
}