@extends('layouts.app')

@section('content')
<div class="index">
    <div class="row header">
        <h3>Все объявления</h3>
         <a class="btn btn-primary" href="{{ action('AdController@create') }}">Добавить объявление</a>
    </div>
    <div class="row list">
        {{ csrf_field() }}
        @foreach($allAds as $ad) 
            <div class="col-md-4 item">
                <div class="item_inner">
                    <div class="item_image">
                        <a href="{{ action('AdController@show',$ad->id) }}">
                            <img class="img-fluid" src="{{ asset($ad->photo) }}">
                        </a>
                    </div>
                    <a class="item_title" href="{{ action('AdController@show',$ad->id) }}">{{ $ad->title }}</a>
                    @if (Auth::user() and Auth::user()->role_id == 1)
                        <a class="item_edit" href="{{action('AdController@edit', $ad->id)}}"><i class="material-icons">create</i></a>
                        <form class="item_delete_wrap" action="{{ action('AdController@destroy', $ad->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="item_delete">
                                <i class="material-icons">delete_forever</i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
       @endforeach
    </div>
    <div class="row">
        <span>{{$allAds->links()}}</span>
    </div>
</div>
@endsection