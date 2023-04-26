<?php

namespace Abd\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Abd\Comment\Models\Comment;
use Abd\Course\Models\Course;
use Abd\Course\Models\Season;
use Abd\Media\Models\Media;
use Abd\Payment\Models\Payment;
use Abd\Payment\Models\Settlement;
use Abd\RolePermissions\Models\Role;
use Abd\Ticket\Models\Reply;
use Abd\Ticket\Models\Ticket;
use Abd\User\Database\Factories\UserFactory;
use Abd\User\Mail\ResetPasswordRequestMail;
use Abd\User\Notifications\ResetPasswordRequestNotification;
use Abd\User\Notifications\VerifyMailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BAN = 'ban';
    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN
    ];

    public static $defaultUsers = [
        'admin' => [
            'name' => 'Admin',
            'email' => 'admin@test.test',
            'password' => 'admin',
            'role' => Role::ROLE_SUPER_ADMIN
        ],
        'teacher' => [
            'name' => 'Teacher',
            'email' => 'teacher@test.test',
            'password' => 'teacher',
            'role' => Role::ROLE_TEACHER
        ],
        'student' => [
            'name' => 'Student',
            'email' => 'student@test.test',
            'password' => 'student',
            'role' => Role::ROLE_STUDENT
        ]
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMailNotification());
    }

    public function sendResetPasswordNotification()
    {
        $this->notify(new ResetPasswordRequestNotification());
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function purchases()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'buyer_id');
    }


    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketReplies()
    {
        $this->hasMany(Reply::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function profilePath()
    {
        return auth()->user()->username ? route('users.profile', auth()->user()->username) : route('users.profile', 'username');
    }

    public function getThumbAttribute()
    {
        if ($this->image)
            return '/storage/' . $this->image->files[300];
        return '/panel/img/profile.jpg';
    }

    public function studentsCount()
    {
        return \DB::table("courses")
            ->select("course_id")->where("teacher_id", $this->id)
            ->join("course_user", "courses.id" , "=","course_user.course_id")->count();
    }

    public function routeNotificationForSms()
    {
        return $this->mobile;
    }

}
