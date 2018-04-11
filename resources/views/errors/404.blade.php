@extends('layouts.app')

@section('content')
     <p> {{ $exception->getMessage() }}</p>
      <p><a href="{{route('ads.index')}}">Вернуться на главную</a></p>
@endsection