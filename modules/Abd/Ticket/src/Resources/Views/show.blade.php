@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="تیکت ها">تیکت ها</a></li>
    <li><a href="#" title="نمایش تیکت">نمایش تیکت</a></li>
@endsection
@section('content')
    <div class="show-comment">
        <div class="ct__header">
            <div class="comment-info">
                <a class="back" href="{{route('tickets.index')}}"></a>
                <div>
                    <p class="comment-name"><a href="">{{$ticket->title}}</a></p>
                </div>
            </div>
        </div>
        @foreach($ticket->replies as $reply)
            <div class="transition-comment {{$reply->user_id == $ticket->user_id ? "" : "is-answer"}}">
                <div class="transition-comment-header">
                       <span>
                            <img src="{{$reply->user->thumb}}" class="logo-pic">
                       </span>
                    <span class="nav-comment-status">
                            <p class="username">کاربر : {{$reply->user->name}}</p>
                            <p class="comment-date">{{$reply->created_at}}</p></span>
                    <div>

                    </div>
                </div>
                <div class="transition-comment-body">
                    <pre>{!! $reply->body !!}</pre>
                    <div>

                    </div>
                </div>
            </div>
        @endforeach
        <div class="transition-comment is-answer">
            <div class="transition-comment-header">
                       <span>
                                         <img src="img/profile.jpg" class="logo-pic">
                       </span>
                <span class="nav-comment-status">
                            <p class="username">مدیر :گوگل</p>
                            <p class="comment-date">10 ماه پیش</p></span>
                <div>

                </div>
            </div>
            <div class="transition-comment-body">
                        <pre>                            سیبیسبسیبسبیسبسیبسی
                            سیبسیبسیبسیبسیبیییییییییی
                            یسبسیبسیبسیب
                        </pre>
                <div>

                </div>
            </div>
        </div>
    </div>

    <div class="answer-comment">
        <p class="p-answer-comment">ارسال پاسخ</p>
        <form action="{{route("tickets.reply", $ticket->id)}}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            <x-textarea placeholder="متن پاسخ" name="body" class="text" required/>
            <x-file name="attachment" placeholder="آپلود فایل پیوست"/>
            <button class="btn btn-brand">ارسال پاسخ</button>
        </form>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
