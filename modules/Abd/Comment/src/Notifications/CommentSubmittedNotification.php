<?php

namespace Abd\Comment\Notifications;

use Abd\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kavenegar\LaravelNotification\KavenegarChannel;
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

    public function via($notifiable): array
    {
        $channels = [
            'mail',
            'database',
        ];
        if (!empty($notifiable->telegram)) $channels[] = "telegram";
        if (!empty($notifiable->mobile)) $channels[] = KavenegarChannel::class;
        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {
        if (!empty($notifiable->telegram))
            return TelegramMessage::create()
                // Optional recipient user id.
                ->to($notifiable->telegram)
                // Markdown supported.
                ->content("یک دیدگاه جدید برای دوره ی شما در سایت عبداله زاده ارسال شده است.")

                // (Optional) Blade template for the content.
                // ->view('notification', ['url' => $url])

                // (Optional) Inline Buttons
                ->button('مشاهده ی دوره', $this->comment->commentable->path())
                ->button('مدیریت دیدگاه ها', route('comments.index'));
        // (Optional) Inline Button with callback. You can handle callback in your bot instance
//            ->buttonWithCallback('Confirm', 'confirm_invoice ' . $this->invoice->id);
    }

    public function toSMS($notifiable)
    {
        return 'یک دیدگاه جدید برای دوره ی شما در سایت عبداله زاده ارسال شده است. جهت مشاهده و ارسال پاسخ، روی لینک زیر کلیک فرمایید.'."\n".route('comments.index');
    }

    public function toArray($notifiable): array
    {
        return [
            "message" => "دیدگاه جدید برای دوره ی شما ثبت شده است.",
            "url" => route('comments.index'),
        ];
    }
}
