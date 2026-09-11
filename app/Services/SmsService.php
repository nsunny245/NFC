<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS message using Twilio or fall back to the mock logger.
     *
     * @param string $to
     * @param string $message
     * @return bool
     */
    public function send(string $to, string $message): bool
    {
        $sid = config('services.twilio.sid');
        $authToken = config('services.twilio.auth_token');
        $from = config('services.twilio.number');

        // Check if credentials are empty, and fall back to mock logger
        if (empty($sid) || empty($authToken) || empty($from)) {
            Log::info("👑 SMS Mock Logger 👑\nTo: {$to}\nMessage: \"{$message}\"\n----------------------------");
            return true;
        }

        try {
            $response = Http::asForm()
                ->withBasicAuth($sid, $authToken)
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'To' => $to,
                    'From' => $from,
                    'Body' => $message,
                ]);

            if ($response->successful()) {
                Log::info("Twilio SMS sent successfully to {$to}.");
                return true;
            }

            Log::error("Twilio SMS dispatch failed to {$to}. Error Response: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Twilio SMS Dispatch Exception for {$to}: " . $e->getMessage());
            return false;
        }
    }
}
