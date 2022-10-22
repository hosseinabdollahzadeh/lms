<?php

namespace Abd\Course\Listeners;

use Abd\Course\Models\Course;
use Abd\Course\Repositories\CourseRepo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterUserInTheCourse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->payment->paymentable_type == Course::class) {
            resolve(CourseRepo::class)->addStudentToCourse($event->payment->paymentable, $event->payment->buyer_id);
        }
    }
}
