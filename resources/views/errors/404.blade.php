@extends('errors.layout')

@php
  $error_number = 404;
@endphp

@section('title')
  آدرس اشتباه
@endsection

@section('description')
  @php
    $default_error_message = "لطفا <a href='javascript:history.back()''>به عقب </a> یا به صفحه <a href='".url('')."'> اصلی </a>برگردید.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?e($exception->getMessage()):$default_error_message): $default_error_message !!}
@endsection
