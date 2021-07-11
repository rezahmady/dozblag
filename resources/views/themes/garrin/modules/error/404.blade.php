@extends('theme::layouts.error')

@section('content')
    <section class="section section-blogs static-show">
        <div class="container-fluid">

            <img class="m-auto d-block mb-3" width="200px" src="{{asset('/uploads/images/themes/garrin/error-404.svg')}}" >
            <h3 class="text-center font-weight-bold mt-3 p-3">صفحه درخواستی شما یافت نشد .</h3>
            <p class="text-center p-3">شاید صفحه منتقل یا حذف شده باشد ، یا شاید شما آدرس را اشتباه گرفته اید.</p>
            <a href="{{ url()->previous() }}" class="btn btn-more m-auto d-table">بازگشت به عقب</a>
        </div>
    </section>
@endsection