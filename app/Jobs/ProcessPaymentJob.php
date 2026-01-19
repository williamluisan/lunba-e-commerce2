<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessPaymentJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $payload = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // simulate payment processing
        logger()->info('Processing Payment', [
            'order' => $this->payload
        ]);
    }
}
