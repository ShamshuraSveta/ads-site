@extends('layouts.app')

@section('content')
<h3>Объявление</h3>
@if (Auth::user() and Auth::user()->role_id == 1)
    <div class="row">
        <div class="col-md-2">
            <a class="btn btn-primary" href="{{ action('AdController@edit', $ad->id) }}">Редактировать</a>
        </div>
        <div class="col-md-2">
            <form action="{{ action('AdController@destroy', $ad->id) }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>
    </div>
    <hr> 
@endif
    <div>
        <img src="{{ asset($ad->photo) }}" width="250px" height="250px">
    </div>
    <div class="full_text">
        <p>{{ $ad->text }}</p>
        <p><strong>Автор: </strong>{{ $ad->user->name }}</p>
        <p><strong>Телефон: </strong>{{ $ad->user->phone }}</p>
        <p><strong>Создано: </strong> <time>{{\Carbon\Carbon::parse($ad->created_at)->format('d.m.Y в H:i')}}</time></p>
    </div>
@if(Auth::user() and Auth::user()->blacklist !== 1)
    <form action="{{ action('CommentController@store') }}" method="POST">
        {{ csrf_field() }}
        <div>
            <input type="hidden" name="id">
        </div>
        <div> 
            <textarea class="form-control" name="text" rows="5" cols="35" placeholder="Введите свой комментарий"></textarea>
        </div>
        <div>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        </div>
        <div>
            <input type="hidden" name="ad_id" value="{{ $ad->id }}">
        </div>
        <div>
            <input type="submit" name="btn" value="Сохранить"/>
        </div>
    </form>
@endif       
@foreach ($comments as $comment)
    <div class="comment">
        <div class="comment_header">
            <strong class="comment_author">
                <i class="material-icons">person</i>{{ $comment->user->name }}    
            </strong>
            <time>{{\Carbon\Carbon::parse($comment->created_at)->format('d.m.Y в H:i')}}</time>
            @if (Auth::user() and (Auth::user()->blacklist !== 1) and (
                
                ($comment->user_id == Auth::user()->id) or 
                ($ad->user_id == Auth::user()->id)
            ))
                <form action="{{ action('CommentController@destroy', $comment->id) }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="del"><i class="material-icons">delete</i></button>
                </form>
            @endif
        </div>
        <div class="comment_text">
            "{{ $comment->text }}"
        </div>
    </div>
    
@endforeach   
{{ $comments->links() }} 
@endsection


