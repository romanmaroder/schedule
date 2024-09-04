<?php


namespace core\useCases\manage\Schedule;


use core\entities\Schedule\Event\Event;
use core\forms\manage\Schedule\Event\EventCopyForm;
use core\forms\manage\Schedule\Event\EventCreateForm;
use core\forms\manage\Schedule\Event\EventEditForm;
use core\repositories\Schedule\EventRepository;
use core\repositories\Schedule\ServiceRepository;
use core\services\TransactionManager;

class EventManageService
{
    private $events;
    private $services;
    private $transaction;

    public function __construct(
        EventRepository $events,
        ServiceRepository $services,
        TransactionManager $transaction,
    ) {
        $this->events = $events;
        $this->services = $services;
        $this->transaction = $transaction;
    }

    public function create(EventCreateForm $form): Event
    {
        $event = Event::create(
            $form->master->master,
            $form->client->client,
            $form->notice,
            $form->start,
            $form->end,
            $form->discount,
            $form->discount_from,
            $form->status,
            $form->payment,
            $form->amount,
            $form->rate,
            $form->price,
            $form->fullname,
        );

        $amount = 0;
        foreach ($form->services->lists as $listId) {
            $service = $this->services->get($listId);
            $amount += $service->price_new;
            $event->assignService($service->id, $service->price_new);
        }
        $event->getAmount($amount);

        $event->rate = $event->employee->rate->rate;
        $event->price = $event->employee->price->rate;
        $event->fullname = $event->employee->getFullName();

        $this->transaction->wrap(
            function () use ($event, $form) {
                $this->events->save($event);
            }
        );
        return $event;
    }

    public function edit($id, EventEditForm $form): void
    {
        $event = $this->events->get($id);

        if ($form->discount_from == 0){
            $form->discount = 0;
        }

        $event->edit(
            $form->master->master,
            $form->client->client,
            $form->notice,
            $form->start,
            $form->end,
            $form->discount,
            $form->discount_from,
            $form->status,
            $form->payment,
            $form->amount,
            $form->rate,
            $form->price,
            $form->fullname,
            $form->tools,
        );
        $this->transaction->wrap(
            function () use ($event, $form) {
                $event->revokeServices();
                $this->events->save($event);

                $amount = 0;
                foreach ($form->services->lists as $listId) {
                    $service = $this->services->get($listId);
                    $event->assignService($service->id, $service->price_new);
                    $amount += $service->price_new;
                }
                $event->getAmount($amount);
                $event->rate = $event->employee->rate->rate;
                $event->price = $event->employee->price->rate;
                $event->fullname = $event->employee->getFullName();
                $this->events->save($event);
            }
        );
    }

    public function copy(EventCopyForm $form): Event
    {

        $event = Event::copy(
            $form->id = $this->events->getLastId()->id + 1,
            $form->master->master,
            $form->client->client,
            $form->notice,
            $form->start,
            $form->end,
            $form->discount,
            $form->discount_from,
            $form->status,
            $form->payment,
            $form->amount,
            $form->rate,
            $form->price,
            $form->fullname,
            $form->tools,
        );

        $amount = 0;
        foreach ($form->services->lists as $listId) {
            $service = $this->services->get($listId);
            $amount += $service->price_new;
            $event->assignService($service->id, $service->price_new);
        }
        $event->getAmount($amount);
        $event->rate = $event->employee->rate->rate;
        $event->price = $event->employee->price->rate;
        $event->fullname = $event->employee->getFullName();
        $this->transaction->wrap(
            function () use ($event, $form) {
                $this->events->save($event);
            }
        );
        return $event;

    }

    public function pay($id)
    {
        $event = $this->events->get($id);
        $event->status = $event->toPay();
        $this->events->save($event);
    }


    public function unpay($id)
    {
        $event = $this->events->get($id);

        $event->status = $event->cancelPay();
        $event->payment = null;
        $this->events->save($event);
    }

    public function cash($id)
    {
        $event = $this->events->get($id);
        $event->payment = $event->cashPayment();
        $this->events->save($event);
    }

    public function card($id)
    {
        $event = $this->events->get($id);
        $event->payment = $event->cardPayment();
        $this->events->save($event);
    }

    public function tools($id)
    {
        $event = $this->events->get($id);
        $event->tools = $event->toolsReady();
        $this->events->save($event);
    }

    public function save($event): void
    {
        $this->events->save($event);
    }

    public function remove($id): void
    {
        $event = $this->events->get($id);
        $this->events->remove($event);
    }
}