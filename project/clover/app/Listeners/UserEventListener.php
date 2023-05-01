<?php

namespace App\Listeners;

use App\Events\UserEvent;
use App\Models\UserActivity;

class UserEventListener
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(UserEvent::class,
            [UserEventListener::class, 'handle']
        );
    }

    public function handle(UserEvent $event)
    {
        try {
            $userEvent = new UserActivity();
            $userEvent->user_id = $event->getUserId();
            $userEvent->event = $event->getEventName();
            $userEvent->created_at = $event->getCreatedDate();
//            $userEvent->created_at = \DateTime::createFromFormat($event->getCreatedDate(), 'UTC');
            $userEvent->updated_at = new \DateTime();
            $userEvent->save();
            echo 1;
        } catch (\Exception $err) {
            echo 2;
        }

    }
}
