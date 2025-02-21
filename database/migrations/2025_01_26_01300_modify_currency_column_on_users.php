<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (DB::connection()->getDriverName() !== 'sqlite') {
                $table->dropForeign('currency_id');
            }

            $table->renameColumn('currency_id', 'currency');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('currency')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('currency')->change();
            $table->renameColumn('currency', 'currency_id');
            $table->foreign('currency_id', 'currency_id')->references('id')->on('currencies');
        });
    }
};
