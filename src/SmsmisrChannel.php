<?php

namespace Ghanem\LaravelSmsmisr;

use Illuminate\Notifications\Notification;

class SmsmisrChannel
{
    /** @var Smsmisr $client */
    protected $client;

    public function __construct(Smsmisr $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification): bool
    {
        $message = $notification->toSmsmisr($notifiable);

        try {
            $response = $this->client->send($message->message, $message->to, $message->sender);

            if ($response['Code'] == 1901) {
                return true;
            }
        } catch (\Exception $e) {
            unset($e);
        }

        return false;
    }
}
