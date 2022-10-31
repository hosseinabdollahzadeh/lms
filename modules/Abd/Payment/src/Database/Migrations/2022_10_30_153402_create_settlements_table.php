<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('transaction_id',30)->nullable();
            $table->json('from')->nullable();
            $table->json('to')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->enum('status', \Abd\Payment\Models\Settlement::$statuses)
                ->default(\Abd\Payment\Models\Settlement::STATUS_PENDING);
            $table->float('amount')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
};
