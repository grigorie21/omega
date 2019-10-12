@extends('layout')

@section('main')
    <h4>Пользователи</h4>
    <form action="{{route('update2')}}" method="POST">
        @csrf
    <div id="app1">
        <index :model="{{$model}}" :user_type_arr="{{$UserTypeArr}}"></index>
    </div>
    </form>
@endsection
