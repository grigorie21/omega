@extends('layout')

@section('main')
    <h4>Редактировать пользователя</h4><br/>
    @include('errors')
    <form action="{{route('update')}}" method="POST">
    @csrf
    <div id="app1">
        <edit :model="{{$model}}" :checkbox_arr="{{$checkboxArr}}" :user_type_arr="{{$UserTypeArr}}"></edit>
    </div>
    </form>
@endsection

