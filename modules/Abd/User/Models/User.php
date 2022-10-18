<?php

namespace Abd\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Abd\Course\Models\Course;
use Abd\Course\Models\Season;
use Abd\Media\Models\Media;
use Abd\RolePermissions\Models\Role;
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

    public function profilePath()
    {
        return auth()->user()->username ? route('viewProfile', auth()->user()->username) : route('viewProfile', 'username');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function getThumbAttribute()
    {
        if ($this->image)
            return '/storage/' . $this->image->files[300];
        return '/panel/img/profile.jpg';
    }

    public function hasAccessToCourse(Course $course)
    {
        if ($this->can('manage', Course::class) ||
            $this->id === $course->teacher_id ||
            $course->students->contains($this->id)
        )
            return true;
        return false;
    }
}
