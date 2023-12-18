<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Schedule\Event\Event;
use schedule\forms\manage\Schedule\Event\EventCreateForm;
use schedule\forms\manage\Schedule\Event\EventEditForm;
use schedule\repositories\Schedule\EventRepository;
use schedule\repositories\Schedule\ServiceRepository;
use schedule\services\TransactionManager;

class EventManageService
{
    private $events;
    private $services;
    private $transaction;

    public function __construct(
        EventRepository $events,
        ServiceRepository $services,
        TransactionManager $transaction
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
        );
        foreach ($form->services->lists as $listId) {
            $service = $this->services->get($listId);
            $event->assignService($service->id);
        }

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
        $event->edit(
            $form->master->master,
            $form->client->client,
            $form->notice,
            $form->start,
            $form->end,
        );
        $this->transaction->wrap(
            function () use ($event, $form) {
                $event->revokeServices();
                $this->events->save($event);

                foreach ($form->services->lists as $listId) {
                    $service = $this->services->get($listId);
                    $event->assignService($service->id);
                }
                $this->events->save($event);
            }
        );
    }

    public function save($event):void
    {
        $this->events->save($event);
    }

    public function remove($id): void
    {
        $event = $this->events->get($id);
        $this->events->remove($event);
    }
}