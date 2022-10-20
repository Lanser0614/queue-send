<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Module\Invoice\Job\SendToPaymentServiceJob;
use App\Module\Invoice\Model\Invoice;
use Illuminate\Console\Command;

class SendInvoiceToServicePayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:send {limit=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for insert invoice for active users';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $invoices = Invoice::query()
            ->where('status', '=', Invoice::NEW_INVOICE)->limit($this->argument('limit'));
        foreach ($invoices->get(['price','id'])->toArray() as $value) {
            SendToPaymentServiceJob::dispatch($value['price'], $value['id']);
        }


    }
}
