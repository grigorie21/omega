@extends('layout')

@section('main')
    <h4>Создать пользователя</h4><br/>
    @include('errors')
    <form action="{{route('store')}}" method="POST">
    @csrf
    <div id="app1">
        <create :checkbox_arr="{{$checkboxArr}}" :user_type_arr="{{$UserTypeArr}}"></create>
    </div>
    </form>
@endsection
