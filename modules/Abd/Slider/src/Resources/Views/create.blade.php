<p class="box__title">ایجاداسلاید جدید</p>
<form action="{{ route('slides.store') }}" method="post" class="padding-30" enctype="multipart/form-data">
    @csrf
    <x-input type="file" name="image" placeholder="تصویر" required />
    <x-input type="number" name="priority" placeholder="اولویت" />
    <x-input type="text" name="link" placeholder="لینک" />
    <p class="box__title margin-bottom-15">وضعیت نمایش</p>
    <select name="status" id="status">
        <option value="1" selected>فعال</option>
        <option value="0">غیر فعال</option>
    </select>
    <button class="btn btn-brand">اضافه کردن</button>
</form>
