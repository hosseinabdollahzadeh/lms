@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="کاربران">کاربران</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">کاربران</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>آیدی</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>نقش کاربری</th>
                        <th>وضعیت تأیید</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr role="row" class="">
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <ul>
                                    @foreach($user->roles as $userRole)
                                        <li class="deleteable-list-item">{{ $userRole->name }}
                                            <a href="" class="item-delete mlg-15" title="حذف"
                                               onclick="deleteItem(event, '{{ route('users.removeRole', [$user->id, $userRole->name])}}', 'li');"></a>
                                        </li>

                                    @endforeach
                                    <a href="#select-role" rel="modal:open" onclick="setFormAction({{$user->id}})">افزودن
                                        نقش کاربری</a>
                                </ul>
                            </td>
                            <td class="confirmation_status">{{$user->hasVerifiedEmail() ? 'تایید شده' : 'تأیید نشده'}}</td>
                            <td>
                                <a href=""
                                   onclick="deleteItem(event, '{{ route('users.destroy', $user->id)}}');"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="{{ route('users.edit', $user->id) }}" class="item-edit mlg-15"
                                   title="ویرایش"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('users.manualVerify', $user->id)}}', 'آیا از تأیید این آیتم اطمینان دارید؟'                                     , 'تأیید شده');"
                                   class="item-confirm mlg-15" title="تایید"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div id="select-role" class="modal">
                    <form action="" id="select-role-form" method="post">
                        @csrf
                        <select name="role">
                            <option value="">یک نقش کاربری انتخاب کنید.</option>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-brand mt-2">افزودن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script>
        function setFormAction(userId) {
            $('#select-role-form').attr('action', '{{route('users.addRole', 0)}}'.replace('/0/', '/' + userId + '/'));
        }
        @include('Common::layouts.feedbacks')
    </script>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
@endsection
