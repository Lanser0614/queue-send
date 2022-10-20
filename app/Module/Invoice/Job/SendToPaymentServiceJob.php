<?php
declare(strict_types=1);

namespace App\Module\Invoice\Job;

use App\Module\Invoice\Model\Invoice;
use App\Module\User\Model\User;
use App\Service\ApiPaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendToPaymentServiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $price;
    private $id;

    public function __construct(int $price, int $id)
    {
        $this->price = $price;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ApiPaymentService $apiPaymentService): void
    {
        $response = $apiPaymentService->payment($this->price);
        $invoice = Invoice::query()->findOrFail($this->id);
        if ($response == 1) {
            $invoice->update(
                [
                    'attempt' => $this->attempts(),
                    'changed_time' => now(),
                    'date' => now(),
                    'created_at' => now(),
                    'last_attempt' => now(),
                    'status' => Invoice::COMPLETE_INVOICE,
                ]
            );
        } else {
            $invoice->update(
                [
                    'attempt' => $this->attempts(),
                    'changed_time' => now(),
                    'date' => now(),
                    'created_at' => now(),
                    'last_attempt' => now(),
                    'status' => Invoice::FAIL_INVOICE,
                ]
            );
            $this->fail();
        }
    }
}
