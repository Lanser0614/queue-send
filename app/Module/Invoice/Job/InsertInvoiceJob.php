<?php

namespace App\Module\Invoice\Job;

use App\Module\Invoice\Model\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertInvoiceJob implements ShouldQueue
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
    private $tariff;
    private $phone;
    private $price;
    private $uuid;
    private $user_id;

    public function __construct(int $tariff, int $phone, int $price, string $uuid, int $user_id)
    {
        $this->tariff = $tariff;
        $this->phone = $phone;
        $this->price = $price;
        $this->uuid = $uuid;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Invoice::query()->create([
            'attempt' => $this->attempts(),
            'changed_time' => now(),
            'date' => now(),
            'created_at' => now(),
            'last_attempt' => now(),
            'status' => Invoice::NEW_INVOICE,
            'tariff' => $this->tariff,
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'price' => $this->price,
            'uuid' => $this->uuid,
        ]);
    }
}
