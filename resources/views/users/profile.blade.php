@extends('layouts.app')
<style>
    .error1 {
        background: gray;
    }
</style>
@section('content')
<div class="index">
    <div class="header">
        <div>
            <h3>Личный кабинет</h3>
            <h4>Все объявления пользователя {{ $user->name }}</h4> 
            <p><a href="../ads">Вернуться на главную</a></p>
        </div>
        <div>
            <p><a class="btn btn-primary add" href="{{ action('AdController@create') }}">Добавить объявление</a></p>
            <p><a class="btn btn-primary" href="{{action('UserController@edit', $user->id)}}">Редактировать профиль</a></p>
        </div>
    </div>
    <table class="table">
        @foreach($allAds as $ad) 
            <tr>
                <td>
                   @if($ad->published !== 1)
                    <p class="error1"><a href="{{ action('AdController@show',$ad->id) }}">{{ $ad->title }}</a></p>
                   
                    @else
                    <p><a href="{{ action('AdController@show',$ad->id) }}">{{ $ad->title }}</a></p>
                    @endif
                    <p>{{ $ad->text }}</p>
                 </td>
                 <td>Тел.: {{ $ad->user->phone }}</td>
                 <td>
                     <div class="">
                         <a href="{{ action('AdController@show',$ad->id) }}"><img src="{{ asset($ad->photo) }}" width="80px" height="80px"></a>
                     </div>
                 </td>
                 <td><time>{{\Carbon\Carbon::parse($ad->created_at)->format('d.m.Y в H:i')}}</time></td>    
                 <td>
                     <a class="btn btn-primary" href="{{ action('AdController@edit', $ad->id) }}">Редактировать</a>
                 </td>
                 <td>
                    <form action="{{ action('AdController@destroy', $ad->id) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-danger">Удалить</button>
                    </form>
                 </td>            
            </tr>
       @endforeach
    </table>
</div>
{{ $allAds->links() }}
@endsection