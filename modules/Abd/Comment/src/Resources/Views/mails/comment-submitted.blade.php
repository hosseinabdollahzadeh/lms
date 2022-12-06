@component('mail::message')
# یک کامنت جدید برای دوره ی {{$comment->commentable->title}} ارسال شده است.
مدرس گرامی یک کامنت جدید برای دوره ی {{$comment->commentable->title}} در سایت حسین عبداله زاده ایجاد شده است. لطفا در اسرع وقت پاسخ مناسب ارسال فرمایید.
@component('mail::panel')
@component('mail::button', ['url' => $comment->commentable->path()])
مشاهده ی دوره
@endcomponent
@endcomponent
با تشکر,<br>
{{ config('app.name') }}
@endcomponent
