<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('currencies');
    }

    public function down(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code', 3)->unique();
            $table->string('symbol', 2)->nullable();
            $table->string('name', 50);
        });
    }
};
