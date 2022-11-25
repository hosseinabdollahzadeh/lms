<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('code')->nullable();
            $table->tinyInteger('percent')->unsigned();
            $table->bigInteger('usage_limitation')->unsigned()->nullable(); // null means unlimited
            $table->timestamp('expire_at')->nullable();
            $table->string('link', 300)->nullable();
            $table->string('description')->nullable();
            $table->enum("type",[\Abd\Discount\Models\Discount::$types])
                ->default(\Abd\Discount\Models\Discount::TYPE_ALL);
            $table->bigInteger('uses')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::create('discountables', function (Blueprint $table) {
            $table->foreignId('discount_id');
            $table->foreignId('discountable_id');
            $table->string('discountable_type');
            $table->primary(["discount_id", "discountable_id", "discountable_type"], "discountable_key");

            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('CASCADE');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discountables');
        Schema::dropIfExists('discounts');
    }
};
