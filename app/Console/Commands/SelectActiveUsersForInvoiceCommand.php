<?php

namespace App\Console\Commands;

use App\Module\Invoice\Job\InsertInvoiceJob;
use App\Module\User\Model\User;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class SelectActiveUsersForInvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:insert';

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
        $users = User::query()->where([
            ['is_verified', '==', true],
            ['is_business', '==', false],
            ['is_stop', '==', false],
        ])->get(['id','phone']);
        foreach ($users->toArray() as $value) {
            InsertInvoiceJob::dispatch(500, $value['phone'], 500, Uuid::uuid4()->toString(), $value['id']);
        }
    }
}
