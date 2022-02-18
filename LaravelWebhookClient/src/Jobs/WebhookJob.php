<?php

namespace Phonglg\LaravelWebhookClient\Jobs;

use Illuminate\Support\Facades\Log;
 

use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class WebhookJob extends ProcessWebhookJob
{
     
    public function handle()
    {
        Log::debug('Webhook client handler111111111');
        Log::debug($this->webhookCall);
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
    }
}
