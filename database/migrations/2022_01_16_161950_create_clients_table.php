<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('email');
            $table->unique(['email', 'user_id'], 'email');
            $table->string('company', 150)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('invoice_prefix', 10);
            $table->unique(['invoice_prefix', 'user_id'], 'invoice_prefix');
            $table->unsignedInteger('invoice_index')->default(1);
            $table->text('note')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
