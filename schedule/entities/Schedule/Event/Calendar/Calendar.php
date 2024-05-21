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

        /*echo'<pre>';
        var_dump($data);
        die();*/
        $events = [];
        foreach ($data as $item) {

            $event = new Event();
            $event->id = $item->id;
            $event->title = $item->client->username ?: $item->fullname;
            $event->extendedProps = [
                'notice' => $item->notice,
                'master' => $item->master->username ?: $item->fullname,
                'service' => $this->serviceNameList($item->services),
            ];
            $event->backgroundColor = $item->employee->color ??  $item->default_color;
            $event->borderColor = $item->employee->color ?? $item->default_color;
            $event->start = $item->start;
            $event->end = $item->end;
            //$event->groupId = 'event';
            $event->source = '/schedule/event/events';
            $event->display = 'block';

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
            $event->id = $item->id;
            $event->title = $item->title;
            $event->extendedProps = [
                'teacher' => $item->teacher->username,
                'student' => $this->studentsName($item->students),
                'description' => $item->description,
            ];
            $event->backgroundColor = $item->color;
            $event->borderColor = $item->color;
            $event->start = $item->start;
            $event->end = $item->end;
            //$event->groupId = 'education';
            $event->source = '/schedule/education/lessons';
            $event->display = 'block';

            $events[] = $event;
        }

        return $events;
    }

    private function serviceNameList($services): string
    {
        $name = '';
        if (is_array($services)) {
            foreach ($services as $service) {
                $name .= $service->name . PHP_EOL;
            }
            return $name;
        }
        throw new \RuntimeException('Service must be array.');
    }

    private  function studentsName($students){
        $name = '';
        if (is_array($students)){
            foreach ($students as $student){
                $name .= $student->username .PHP_EOL;
            }
            return $name;
        }
        throw new \RuntimeException('Students must be array.');
    }
}