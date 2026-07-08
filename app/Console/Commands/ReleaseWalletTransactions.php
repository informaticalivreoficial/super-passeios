<?php

namespace App\Console\Commands;

use App\Enums\WalletStatusEnum;
use Illuminate\Console\Command;
use App\Models\WalletTransaction;

class ReleaseWalletTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        WalletTransaction::query()

        ->where('status',WalletStatusEnum::Pending)
        ->where('available_at','<=',now())
        ->update([
            'status'=>WalletStatusEnum::Available
        ]);
    }
}
