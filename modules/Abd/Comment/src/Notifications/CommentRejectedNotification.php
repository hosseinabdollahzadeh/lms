<?php

namespace Abd\Comment\Notifications;

use Abd\Comment\Mail\CommentSubmittedMail;
use Abd\Comment\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kavenegar\LaravelNotification\KavenegarChannel;
use NotificationChannels\Telegram\TelegramMessage;
use function url;

class CommentRejectedNotification extends Notification
{
    use Queueable;

    public Comment $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        //
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [
            'mail',
            'database',
        ];
        if (!empty($notifiable->telegram)) $channels[] = "telegram";
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
                ->content("دیدگاه شما رد شد.")

                // (Optional) Blade template for the content.
                // ->view('notification', ['url' => $url])

                // (Optional) Inline Buttons
                ->button('مشاهده ی دوره', $this->comment->commentable->path());
        // (Optional) Inline Button with callback. You can handle callback in your bot instance
//            ->buttonWithCallback('Confirm', 'confirm_invoice ' . $this->invoice->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "message" => "دیدگاه شما رد شد.",
            "url" => $this->comment->commentable->path(),
        ];
    }
}
