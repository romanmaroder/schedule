<?php


namespace schedule\entities\Schedule\Event\Calendar;


use schedule\readModels\Schedule\EventReadRepository;
use yii2fullcalendar6\models\Event;

class Calendar
{
    public EventReadRepository $service;

    /**
     * Calendar constructor.
     */
    public function __construct()
    {
        $this->service = new EventReadRepository(); // TODO To think of a better way to do it
    }

    public function getEvents(): array
    {

        $data = $this->service->getAll();
        $events = [];
        foreach ($data as $item) {
            $event = new Event();
            $event->id = $item->id;
            $event->title = $item->client->username;

            $event->extendedProps = [
                'notice' => $item->notice,
                'master' => $item->master->username,
                'service' => $this->serviceNameList($item->services),
            ];
            $event->start = $item->start;
            $event->end = $item->end;

            $events[] = $event;
        }
        return $events;
    }

    public function education(): array
    {
        $data = [
            [
                'id' => '6061',
                'notice' => 'TEST 1',
                'client_id' => '11',
                'master_id' => '2',
                'service' => 'Стопа',
                'color' => '#000080',
                'event_time_start' => '2023-11-25 14:00:00',
                'event_time_end' => '2023-11-25 16:30:00'
            ],
            [
                'id' => '6062',
                'notice' => 'TEST 2',
                'client_id' => '10',
                'master_id' => '2',
                'service' => 'Стопа',
                'color' => '#A52A2A',
                'event_time_start' => '2023-11-25 09:00:00',
                'event_time_end' => '2023-11-25 09:30:00'
            ],
            [
                'id' => '6064',
                'notice' => 'TEST 3',
                'client_id' => '13',
                'master_id' => '2',
                'service' => 'Стопа',
                'color' => '#2F4F4F',
                'event_time_start' => '2023-11-25 10:00:00',
                'event_time_end' => '2023-11-25 10:30:00'
            ]
        ];
        $events = [];
        foreach ($data as $item) {
            $event = new Event();
            $event->id = $item['id'];
            $event->title = $item['client_id'];
            $event->extendedProps = [
                'notice' => $item['notice'],
                'master' => $item['master_id'],
                'service'=>$item['service']
            ];
            $event->backgroundColor = $item['color'];
            $event->start = $item['event_time_start'];
            $event->end = $item['event_time_end'];

            $events[] = $event;
        }
        return $events;
    }


    private function serviceNameList($services): string
    {
        $name = '';
        foreach ($services as $service) {
            $name .= $service->name .PHP_EOL;
        }
        return $name;
    }
}