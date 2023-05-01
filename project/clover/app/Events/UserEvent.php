<?php

namespace App\Events;

class UserEvent extends Event
{
    private $userId;
    private $eventName;
    private $createdDate;

    public function __construct(string $userId, string $eventName, \DateTime $createdDate)
    {
        $this->userId = $userId;
        $this->eventName = $eventName;
        $this->createdDate = $createdDate;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getCreatedDate(): \DateTime
    {
        return $this->createdDate;
    }
}
