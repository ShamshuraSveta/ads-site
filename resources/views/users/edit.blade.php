@extends('layouts.app')
    <style>
        .error {
            color: red;
        }
    </style>
@section('content')
    <h4>Редактировать профиль</h4>
    <form action="{{ action('UserController@update', $user->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div>
            <input type="hidden" name="id" value="{{ $user->id }}">
        </div>
        <div class="form-group">
            <label for="text_id">ФИО: </label>
            <input class="form-control" id="text_id" type="text" name="name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="email_id">Email: </label>
            <input class="form-control" id="email_id" type="email" name="email" value="{{ $user->email }}">
        </div>
        <div class="form-group">
             <label for="phone_id">Телефон: </label>
             <input class="form-control" id="phone_id" type="text" name="phone" value="{{ $user->phone }}">
        </div>
        @if (Auth::user()->hasRole('admin'))
        <div class="form-check">
            <input class="form-check-input" type="hidden" name="blacklist" value="0">
            <input class="form-check-input" id="defaultCheck2" type="checkbox" name="blacklist" value="1" {{ ($user->blacklist == 1)  ? 'checked' : '' }}>
            <label class="form-check-label" for="defaultCheck2">Черный список </label>
        </div>
        @endif
            <input class="btn btn-primary" type="submit" name="btn" value="Сохранить"/>
    </form>
    @if(count($errors) > 0)
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection