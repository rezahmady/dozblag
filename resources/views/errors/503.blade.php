@extends('errors.layout')

@php
  $error_number = 503;
@endphp

@section('title')
    سیستم در دسترس نمی باشد
@endsection

@section('description')
  @php
    $default_error_message = "سیستم در دسترس نمی باشد .";
  @endphp
  لطفا بعدا مراجعه کنید
{{--  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}--}}
@endsection
