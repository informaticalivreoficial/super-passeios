<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->addForeignKeyIfMissing(
            'wallet_transactions',
            'wallet_transactions_withdrawal_id_foreign',
            'withdrawal_id',
            'withdrawals'
        );

        $this->addForeignKeyIfMissing(
            'withdrawals',
            'withdrawals_bank_account_id_foreign',
            'bank_account_id',
            'bank_accounts'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropForeignKeyIfExists('wallet_transactions', 'wallet_transactions_withdrawal_id_foreign');
        $this->dropForeignKeyIfExists('withdrawals', 'withdrawals_bank_account_id_foreign');
    }

    protected function addForeignKeyIfMissing(string $table, string $constraint, string $column, string $references): void
    {
        if ($this->foreignKeyExists($table, $constraint)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($column, $references) {
            $table->foreign($column)->references('id')->on($references)->nullOnDelete();
        });
    }

    protected function dropForeignKeyIfExists(string $table, string $constraint): void
    {
        if (! $this->foreignKeyExists($table, $constraint)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($constraint) {
            $table->dropForeign($constraint);
        });
    }

    protected function foreignKeyExists(string $table, string $constraint): bool
    {
        $result = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?',
            [$table, $constraint]
        );

        return (int) $result->total > 0;
    }
};