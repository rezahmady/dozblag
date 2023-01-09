@extends('errors.layout')

@php
  $error_number = 403;
@endphp

@section('title')
  ورود ممنوع
@endsection

@section('description')
  @php
    $default_error_message = "لطفا <a href='javascript:history.back()''>به عقب </a> یا به  <a href='".url('')."'>صفحه اصلی </a>برگردید.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?e($exception->getMessage()):$default_error_message): $default_error_message !!}
@endsection
