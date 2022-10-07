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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('season_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('media_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->boolean('is_free')->default(false);
            $table->tinyInteger('time')->unsigned()->nullable();
            $table->integer('number')->unsigned()->nullable();
            $table->enum('confirmation_status', \Abd\Course\Models\Lesson::$confirmationStatuses)
                ->default(\Abd\Course\Models\Lesson::CONFIRMATION_STATUS_PENDING);
            $table->enum('status', \Abd\Course\Models\Lesson::$statuses)
                ->default(\Abd\Course\Models\Lesson::STATUS_OPENED);
            $table->longText('body')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('CASCADE');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
