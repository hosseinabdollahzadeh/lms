<p class="box__title">ایجاد دسته بندی جدید</p>
<form action="{{ route('categories.store') }}" method="post" class="padding-30">
    @csrf
    <input type="text" name="title" placeholder="نام دسته بندی" class="text" value="{{old("title")}}">
    @error('title')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <input type="text" name="slug" placeholder="نام انگلیسی دسته بندی" class="text" value="{{old("slug")}}">
    @error('slug')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
    <select name="parent_id" id="parent_id">
        <option value="">ندارد</option>
        @foreach($categories as $category)
            <option value="{{old($category->id)}}">{{$category->title}}</option>
        @endforeach
    </select>
    @error('parent_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <hr>
    <button class="btn btn-brand">اضافه کردن</button>
</form>
