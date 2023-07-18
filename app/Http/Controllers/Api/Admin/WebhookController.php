<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DefaultResponseResource;
use App\Jobs\WebhookJob;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends ApiController
{
    public function sendWebhook(Request $request, Invoice $invoice): DefaultResponseResource
    {
	    Log::channel('supportLog')->info('Try send resend webhook for ' . $invoice->id);

        WebhookJob::dispatchSync($invoice, true);

        return (new DefaultResponseResource([]));
    }
}
