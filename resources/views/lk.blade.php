@extends('layouts.app')

@section('content')
    @isset($user)
        {{$user->name}}<br>
        {{$user->email}}<br>
    @endisset
@endsection
