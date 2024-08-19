<?php


namespace core\useCases\manage\Schedule;


use core\entities\Schedule\Event\FreeTime;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeCopyForm;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeCreateForm;
use core\forms\manage\Schedule\Event\FreeTime\FreeTimeEditForm;
use core\repositories\Schedule\AdditionalRepository;
use core\repositories\Schedule\FreeTimeRepository;
use core\services\TransactionManager;

class FreeTimeManageService
{
    private $freeTime;
    private $additional;
    private $transaction;

    public function __construct(
        FreeTimeRepository $freeTime,
        AdditionalRepository $additional,
        TransactionManager $transaction,
    ) {
        $this->freeTime = $freeTime;
        $this->additional = $additional;
        $this->transaction = $transaction;
    }

    public function create(FreeTimeCreateForm $form): FreeTime
    {
        $free = FreeTime::create(
            $form->master->master,
            $form->additional->additional,
            $form->start,
            $form->end,
            $form->notice,
        );


        $this->transaction->wrap(
            function () use ($free, $form) {
                $this->freeTime->save($free);
            }
        );
        return $free;
    }

    public function edit($id, FreeTimeEditForm $form): void
    {
        $free = $this->freeTime->get($id);

        $free->edit(
            $form->master->master,
            $form->additional->additional,
            $form->start,
            $form->end,
            $form->notice
        );
        $this->transaction->wrap(
            function () use ($free, $form) {
                $this->freeTime->save($free);
            }
        );
    }

    public function copy(FreeTimeCopyForm $form): FreeTime
    {

        $free = FreeTime::copy(
            $form->id = $this->freeTime->getLastId()->id + 1,
            $form->master->master,
            $form->additional->additional,
            $form->start,
            $form->end,
            $form->notice
        );

        $this->transaction->wrap(
            function () use ($free, $form) {
                $this->freeTime->save($free);
            }
        );
        return $free;

    }

    public function save($free): void
    {
        $this->freeTime->save($free);
    }

    public function remove($id): void
    {
        $event = $this->freeTime->get($id);
        $this->freeTime->remove($event);
    }
}