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
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("ticket_id");
            $table->foreignId("media_id")->nullable();
            $table->text("body");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("CASCADE");
            $table->foreign("ticket_id")->references("id")->on("tickets")->onDelete("CASCADE");
            $table->foreign("media_id")->references("id")->on("media")->onDelete("SET NULL");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_replies');
    }
};
