<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurgeDeletedCompanies extends Command
{
    protected $signature = 'companies:purge-deleted';

    protected $description = 'Exclui permanentemente empresas com exclusão agendada e vencida';

    public function handle(): void
    {
        $companies = Company::whereNotNull('deletion_scheduled_for')
            ->whereNull('deletion_cancelled_at')
            ->where('deletion_scheduled_for', '<=', now())
            ->get();

        $total = 0;

        foreach ($companies as $company) {
            DB::transaction(function () use ($company) {
                $company->tours()->get()->each->delete();
                $company->vessels()->get()->each->delete();

                $customers = Customer::where('company_id', $company->id)->get();
                foreach ($customers as $customer) {
                    DB::table('notifications')
                        ->where('notifiable_type', Customer::class)
                        ->where('notifiable_id', $customer->id)
                        ->delete();

                    $customer->delete();
                }

                $company->delete();
            });

            $total++;
        }

        $this->info("PurgeDeletedCompanies: {$total} empresas excluídas permanentemente.");
    }
}