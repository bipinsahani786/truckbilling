<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTripNotification extends Notification
{
    use Queueable;

    private $trip;

    public function __construct($trip)
    {
        $this->trip = $trip;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'new_trip',
            'title' => 'New Trip Assigned',
            'message' => "You have been assigned to a new trip from {$this->trip->source_location} to {$this->trip->destination_location}.",
            'trip_id' => $this->trip->id,
            'source' => $this->trip->source_location,
            'destination' => $this->trip->destination_location,
        ];
    }
}
