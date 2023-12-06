<?php


namespace schedule\entities\Schedule\Event\Calendar;


use schedule\readModels\Schedule\EducationReadRepository;
use schedule\readModels\Schedule\EventReadRepository;
use yii2fullcalendar6\models\Event;

class Calendar
{
    public EventReadRepository $events;
    public EducationReadRepository $educations;

    /**
     * Calendar constructor.
     * @param EventReadRepository $events
     * @param EducationReadRepository $educations
     */
    public function __construct(
        EventReadRepository $events,
        EducationReadRepository $educations
    ) {
        $this->events = $events; // TODO To think of a better way to do it
        $this->educations = $educations;
    }

    public function getEvents(): array
    {
        $data = $this->events->getAll();
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

    public function getEducations(): array
    {
        $data = $this->educations->getAll();
        $events = [];
        foreach ($data as $item) {
            $event = new Event();
            $event->id = $item['id'];
            $event->title = $item['title'];
            $event->extendedProps = [
                'teacher' => $item['teacher_id'],
                'student'=>$item['student_id'],
                'description' => $item['description'],
            ];
            $event->backgroundColor = $item['color'];
            $event->borderColor = $item['color'];
            $event->start = $item['start'];
            $event->end = $item['end'];

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