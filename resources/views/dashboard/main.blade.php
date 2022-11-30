@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('main')
    <div class="container">
        <h1>Welcome {{ session('user')->first_name }} {{ session('user')->last_name }}</h1>
    </div>
@endsection
