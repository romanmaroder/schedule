<?php


namespace core\entities\Schedule\Event\Calendar;


use core\helpers\ToolsHelper;
use core\readModels\Schedule\EducationReadRepository;
use core\readModels\Schedule\EventReadRepository;
use core\readModels\Schedule\FreeTimeReadRepository;
use yii2fullcalendar6\models\Event;

class Calendar
{
    public EventReadRepository $events;
    public EducationReadRepository $educations;
    public FreeTimeReadRepository $freeTime;

    /**
     * Calendar constructor.
     * @param EventReadRepository $events
     * @param EducationReadRepository $educations
     * @param FreeTimeReadRepository $freeTime
     */
    public function __construct(
        EventReadRepository $events,
        EducationReadRepository $educations,
        FreeTimeReadRepository $freeTime
    ) {
        $this->events = $events; // TODO To think of a better way to do it
        $this->educations = $educations;
        $this->freeTime = $freeTime;
    }

    public function getEvents(): array
    {
        $data = $this->events->getAll();

        $events = [];
        foreach ($data as $item) {

            $event = new Event();
            $event->id = $item->id;
            $event->title = $item->client->username ?: $item->fullname;
            $event->extendedProps = [
                'notice' => $item->notice,
                'master' => $item->getFullName(),
                'service' => $this->serviceNameList($item->services),
                'tools' => ToolsHelper::statusLabel($item->tools),
                'resourceId' => $item->master->id,
            ];
            $event->backgroundColor = $item->getDefaultColor();
            $event->borderColor = $item->getDefaultColor();
            $event->start = $item->start;
            $event->end = $item->end;
            //$event->groupId = $item->master->id;
            $event->source = '/schedule/event/events';
            $event->display = 'block';

            $events[] = $event;
        }

        return $events;
    }


    public function getFree(): array
    {
        $data = $this->freeTime->getAll();

        $freeTime= [];
        foreach ($data as $item) {

            $free = new Event();
            $free->id = $item->id;
            $free->title = $item->master->username ?: $item->fullname;
            $free->extendedProps = [
                'notice' => $item->notice,
                'master' => $item->employee->getFullName(),
                'additional' => $item->additional->name,
                'resourceId' => $item->master->id,
            ];
            $free->backgroundColor = $item->employee->color ??  $item->default_color;
            $free->borderColor = $item->employee->color ?? $item->default_color;
            $free->start = $item->start;
            $free->end = $item->end;
            $free->groupId = $item->master->id;
            $free->source = '/schedule/free-time/free';
            $free->display = 'block';

            $freeTime[] = $free;
        }

        return $freeTime;
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
                //'resourceId' => $item->master->id,
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