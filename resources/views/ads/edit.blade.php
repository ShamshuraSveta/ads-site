@extends('layouts.app')
    <style>
        .error {
            color: red;
        }
    </style>
@section('content')
    <h4>Редактировать объявление</h4>
    <form action="{{ action('AdController@update', $ad->id) }}" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
            <div>
                <input type="hidden" name="id" value="{{ $ad->id }}">
            </div>
            <div>
                <label for="exampleFormControlInput1">Заголовок: </label>
               <input type="text" name="title" class="form-control" id="exampleFormControlInput1" value="{{ $ad->title }}">
            </div>
             <div class="form-group">
                <label for="exampleFormControlTextarea1">Текст объявления: </label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="text" rows="15" cols="35">{{ $ad->text }}</textarea>
            </div>
            <div>
                <input type="hidden" name="user_id" value="{{$ad->user_id}}">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput2">Фото: </label>
                <input class="form-control-file" id="exampleFormControlInput2" type="file" name="photo">
            </div>
            @if (Auth::user()->hasRole('admin'))
                <div class="form-group">
                    <label for="published">Опубликовать</label>
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" id="published" name="published" value="1" {{ $ad->published == 1  ? 'checked' : '' }}>
                </div>
            @endif
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="btn" value="Сохранить"/>
            </div>
        </div>
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