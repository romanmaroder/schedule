<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\forms\CompositeForm;
use core\helpers\tHelper;

/**
 * @property AdditionalForm $additional
 * @property MasterForm $master
 */
class FreeTimeCreateForm extends CompositeForm
{
    public $start;
    public $end;
    public $notice;

    public function __construct($config = [])
    {
        $this->additional = new AdditionalForm();
        $this->master = new MasterForm();
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['start', 'end'], 'required'],
            [['notice'],'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'start' => tHelper::translate('schedule/free','Start'),
            'end' => tHelper::translate('schedule/free','End'),
            'notice' => tHelper::translate('schedule/free','Notice'),
        ];
    }
    protected function internalForms(): array
    {
        return ['additional','master'];
    }
}