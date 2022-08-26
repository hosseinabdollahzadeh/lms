@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دسته بندی ها">دوره ها</a></li>
    <li><a href="#" title="ویرایش دوره">ویرایش دوره</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی دوره</p>
            <form action="{{route('courses.store')}}" class="padding-30" method="post">
                @csrf
                <x-input type="text" name="title" placeholder="عنوان دوره" required />
                <x-input type="text" name="slug" class="text-left " placeholder="نام انگلیسی دوره" required />

                <div class="d-flex multi-text">
                    <x-input type="text" name="priority" class="text-left" placeholder="ردیف دوره"/>
                    <x-input type="text" name="price" placeholder="مبلغ دوره" class="text-left" required/>
                    <x-input type="number" name="percent" placeholder="درصد مدرس" class="text-left" required/>
                </div>
                <select name="teacher_id" required>
                    <option value="">انتخاب مدرس دوره</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                    @endforeach
                </select>
                <x-validation-error field="teacher_id" />
                <ul class="tags">
                    <li class="addedTag">dsfsdf<span class="tagRemove" onclick="$(this).parent().remove();">x</span>
                        <input type="hidden" value="dsfsdf" name="tags[]"></li>
                    <li class="addedTag">dsfsdf<span class="tagRemove" onclick="$(this).parent().remove();">x</span>
                        <input type="hidden" value="dsfsdf" name="tags[]"></li>
                    <li class="tagAdd taglist">
                        <input type="text" name="tags" id="search-field" placeholder="برچسب ها">
                    </li>
                </ul>
                <select name="type" required>
                    <option value="">نوع دوره</option>
                    @foreach(\Abd\Course\Models\Course::$types as $type)
                    <option value="{{$type}}">@lang($type)</option>
                    @endforeach
                </select>
                <x-validation-error field="type" />
                <select name="status" required>
                    <option value="">وضعیت دوره</option>
                    @foreach(\Abd\Course\Models\Course::$statuses as $status)
                        <option value="{{$status}}">@lang($status)</option>
                    @endforeach
                </select>
                <x-validation-error field="status" />
                <select name="category_id" required>
                    <option value="">زیر دسته بندی</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
                <x-validation-error field="category_id" />
                <div class="file-upload">
                    <div class="i-file-upload">
                        <span>آپلود بنر دوره</span>
                        <input type="file" class="file-upload" id="files" name="image" required/>
                    </div>
                    <span class="filesize"></span>
                    <span class="selectedFiles">فایلی انتخاب نشده است</span>
                </div>
                <x-validation-error field="image" />
                <textarea name="body" placeholder="توضیحات دوره" class="text h"></textarea>
                <x-validation-error field="body" />
                <button class="btn btn-brand">ایجاد دوره</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
