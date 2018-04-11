@extends('layouts.app')

@section('content')
    <h3>Все пользователи</h3>
    <p><a href="./ads">Вернуться на главную</a></p>
    <table class="table">
        {{ csrf_field() }}
        <tr>
            <td><strong>ФИО: </strong></td>
            <td><strong>Email: </strong></td>
            <td><strong>Телефон: </strong></td>
            <td><strong>Черный список: </strong></td>
            <td></td>
            <td></td>
        </tr>
        @foreach($users as $user) 
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ ($user->blacklist == 1)  ? 'Да' : 'Нет' }}</td>
                @if (Auth::user() and Auth::user()->role_id == 1)
                    <td>
                        <a class="btn btn-primary" href="{{ action('UserController@edit', $user->id) }}">Редактировать</a>
                    </td>
                    <td>
                        <form action="{{ action('UserController@destroy', $user->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </td>   
                 @endif
            </tr>
        @endforeach
    </table>
{{$users->links()}}        
@endsection