@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('main')
    <div class="container">
        Welcome {{ session('user')->first_name }} {{ session('user')->last_name }}
    </div>
@endsection
