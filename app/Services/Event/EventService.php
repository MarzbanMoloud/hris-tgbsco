<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 12/8/2019
 * Time: 11:28 AM
 */

namespace App\Services\Event;


use App\Event;
use App\ValueObject\CreateEvent;
use App\ValueObject\UpdateEvent;


/**
 * Class EventService
 * @package App\Services\Event
 */
class EventService
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $events = Event::latest();
        if ($paginate){
            return $events->paginate();
        }
        return $events->get();
    }

    /**
     * @param $eventId
     * @return mixed
     */
    public function findById($eventId)
    {
        return Event::where('id', $eventId)->first();
    }

    /**
     * @param CreateEvent $job
     * @return Event
     */
    public function create(CreateEvent $job) :Event
    {
        return Event::create([
            'title' => $job->getTitle(),
            'caption' => $job->getCaption(),
            'alert_date' => $job->getAlertDate(),
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * @param UpdateEvent $updateEvent
     * @param Event $event
     */
    public function update(UpdateEvent $updateEvent, Event $event)
    {
        $event->update([
            'title' => $updateEvent->getTitle(),
            'caption' => $updateEvent->getCaption(),
            'alert_date' => $updateEvent->getAlertDate(),
            'updated_by' => auth()->id(),
        ]);
    }
}