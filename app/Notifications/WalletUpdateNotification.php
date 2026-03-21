<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WalletUpdateNotification extends Notification
{
    use Queueable;

    private $wallet;
    private $amount;
    private $description;

    public function __construct($wallet, $amount, $description)
    {
        $this->wallet = $wallet;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'wallet_update',
            'title' => 'Wallet Updated',
            'message' => "Amount {$this->amount} credited to your wallet. Reason: {$this->description}.",
            'wallet_id' => $this->wallet->id,
            'amount' => $this->amount,
        ];
    }
}
