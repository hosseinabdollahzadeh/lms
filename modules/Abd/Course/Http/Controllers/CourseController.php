<?php

namespace Abd\Course\Http\Controllers;

use Abd\Category\Repositories\CategoryRepo;
use Abd\Common\Responses\AjaxResponses;
use Abd\Course\Repositories\CourseRepo;
use Abd\Course\Http\Requests\CourseRequest;
use Abd\Course\Models\Course;
use Abd\Course\Repositories\LessonRepo;
use Abd\Media\Services\MediaFileService;
use Abd\Payment\Services\PaymentService;
use Abd\RolePermissions\Models\Permission;
use Abd\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('index', Course::class);
        if (auth()->user()->hasAnyPermission([Permission::PERMISSION_MANAGE_COURSES, Permission::PERMISSION_SUPER_ADMIN])) {
            $courses = $courseRepo->paginate();
        } else {
            $courses = $courseRepo->getCoursesByTeacherId(auth()->id());
        }
        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('create', Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $this->authorize('create', Course::class);
        $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }

    public function details($id, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {
        $course = $courseRepo->findById($id);
        $lessons = $lessonRepo->paginate($id);
        $this->authorize('details', $course);
        return view('Courses::details', compact('course', 'lessons'));
    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $this->authorize('delete', Course::class);
        $course = $courseRepo->findById($id);

        if ($course->banner) {
            $course->banner->delete();
        }
        $course->delete();
        AjaxResponses::SuccessResponse();
    }

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit', $course);

        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::edit', compact('course', 'teachers', 'categories'));

    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit', $course);

        if ($request->hasFile('image')) {
            $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($course->banner) {
                $course->banner->delete();
            }
        } else {
            $request->request->add(['banner_id' => $course->banner_id]);
        }
        $courseRepo->update($id, $request);
        return redirect(route('courses.index'));
    }

    public function accept($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function reject($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function lock($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateStatus($id, Course::STATUS_LOCKED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function buy($courseId, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($courseId);
        if (!$this->CourseCanBePurchased()) {
            return back();
        }

        if (!$this->authUserCanPurchaseCourse($courseId)) {

            return back();
        }
        $amount = $course->getFinalPrice();
        $payment = PaymentService::generate($amount, $course, auth()->user());
    }

    private function CourseCanBePurchased(Course $course)
    {
        if ($course->type == Course::TYPE_FREE) {
            newFeedback("عملیات ناموفق", "دوره های رایگان قابل خریداری نیستند!", "error");
            return false;
        }
        if ($course->status == Course::STATUS_LOCKED) {
            newFeedback("عملیات ناموفق", "این دوره قفل شده و فعلا قابل خریداری نیست!", "error");
            return false;
        }
        if ($course->confirmation_status != Course::CONFIRMATION_STATUS_ACCEPTED) {
            newFeedback("عملیات ناموفق", "دوره ی انتخابی شما هنوز تأیید نشده است!", "error");
            return false;
        }
        return true;
    }

    private function authUserCanPurchaseCourse(Course $course)
    {
        if (auth()->id() == $course->teacher_id) {
            newFeedback("عملیات ناموفق", "شما مدرس این دوره هستید.", "error");
            return false;
        }

        if (auth()->user()->hasAccessToCourse($course)) {
            newFeedback("عملیات ناموفق", "شما به دوره دسترسی دارید.", "error");
            return false;
        }

        return true;
    }
}
