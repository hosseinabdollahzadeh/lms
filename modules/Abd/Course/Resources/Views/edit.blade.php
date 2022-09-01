@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره ها">دوره ها</a></li>
    <li><a href="#" title="ویرایش دوره">ویرایش دوره</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی دوره</p>
            <form action="{{route('courses.update', $course->id)}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <x-input type="text" name="title" placeholder="عنوان دوره" value="{{$course->title}}" required/>
                <x-input type="text" name="slug" class="text-left " placeholder="نام انگلیسی دوره" value="{{$course->slug}}"  required />

                <div class="d-flex multi-text">
                    <x-input type="text" name="priority" class="text-left" placeholder="ردیف دوره"
                             value="{{$course->priority}}" />
                    <x-input type="text" name="price" placeholder="مبلغ دوره" class="text-left"
                             value="{{$course->price}}" required/>
                    <x-input type="number" name="percent" placeholder="درصد مدرس" class="text-left"
                             value="{{$course->percent}}" required/>
                </div>
                <x-select name="teacher_id" required>
                    <option value="">انتخاب مدرس دوره</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}" @if($teacher->id == $course->teacher_id) selected @endif>{{$teacher->name}}</option>
                    @endforeach
                </x-select>
                <x-tag-select name="tags" />

                <x-select name="type" required>
                    <option value="">نوع دوره</option>
                    @foreach(\Abd\Course\Models\Course::$types as $type)
                    <option value="{{$type}}"@if($type == $course->type) selected @endif>@lang($type)</option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">وضعیت دوره</option>
                    @foreach(\Abd\Course\Models\Course::$statuses as $status)
                        <option value="{{$status}}" @if($status == $course->status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="category_id" required>
                    <option value="">زیر دسته بندی</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" @if($category->id == $course->category_id) selected @endif>{{$category->title}}</option>
                    @endforeach
                </x-select>

                <x-file name="image" placeholder="آپلود بنر دوره" :Value="$course->banner" />

                <x-textarea name="body" placeholder="توضیحات دوره" value="{{$course->body}}"/>
                <br>
                <button class="btn btn-brand">به روز رسانی دوره</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
