<?php

namespace Abd\Comment\Notifications;

use Abd\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use function url;

class CommentSubmittedNotification extends Notification
{
    use Queueable;
    public $comment;
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable) : array
    {
        return ['mail', 'telegram'];
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to(967259502)
            // Markdown supported.
            ->content("یک دیدگاه جدید برای دوره ی شما در وب آموز ارسال شده است.")

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons
            ->button('مشاهده ی دوره', $this->comment->commentable->path())
            ->button('مدیریت دیدگاه ها', route('comments.index'));
            // (Optional) Inline Button with callback. You can handle callback in your bot instance
//            ->buttonWithCallback('Confirm', 'confirm_invoice ' . $this->invoice->id);
    }

    public function toArray($notifiable) : array
    {
        return [
            //
        ];
    }
}
