@extends('layouts.app')
     <style>
        .error {
            color: red;
        }
    </style>
@section('content')
    <h4>Добавить объявление</h4>
   
    <form action="{{url('/ads')}}" method="POST" enctype="multipart/form-data">
     {{ csrf_field() }}
        <div>
            <input type="hidden" name="id">
        </div>
        <div class="form-group">
            <label for="title_id">Заголовок: </label>
            <input class="form-control" id="title_id" type="text" name="title">
        </div>
        <div class="form-group">
            <label for="text_id">Текст объявления:</label> 
            <textarea class="form-control" id="text_id" name="text" rows="5" cols="35"></textarea>
        </div>
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <div class="form-group">
            <label for="photo_id">Фото:</label>
            <input class="form-control-file" id="photo_id" type="file" name="photo">
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="btn" value="Сохранить"/>
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