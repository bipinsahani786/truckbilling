<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VehicleExpiryNotification extends Notification
{
    use Queueable;

    private $vehicle;
    private $documentType;
    private $expiryDate;

    public function __construct($vehicle, $documentType, $expiryDate)
    {
        $this->vehicle = $vehicle;
        $this->documentType = $documentType;
        $this->expiryDate = $expiryDate;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'vehicle_expiry',
            'title' => 'Vehicle Document Expiry Alert',
            'message' => "The {$this->documentType} for vehicle {$this->vehicle->vehicle_number} is expiring on {$this->expiryDate}.",
            'vehicle_id' => $this->vehicle->id,
            'document_type' => $this->documentType,
            'expiry_date' => $this->expiryDate,
        ];
    }
}
