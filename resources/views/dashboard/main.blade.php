@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('main')
    <div class="container">
        <h1>Welcome {{ session('user')->first_name }} {{ session('user')->last_name }}</h1>
    </div>

    <div class="container">
        @if ($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        <form action="{{ route('dashboard.profileUpdate') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input class="form-control" type="email" id="email" name="email" placeholder="{{ __('Email Address') }}"
                    required autocomplete="off" value="{{ $me->email }}">
                <label for="email">{{ __('Email Address') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="first_name" name="first_name"
                    placeholder="{{ __('First Name') }}" required autocomplete="off" value="{{ $me->first_name }}">
                <label for="first_name">{{ __('First Name') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="last_name" name="last_name"
                    placeholder="{{ __('Last Name') }}" required autocomplete="off" value="{{ $me->last_name }}">
                <label for="last_name">{{ __('Last Name') }}</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-control" name="gender" id="gender" placeholder="{{ __('Gender') }}">
                    <option value="male" @if ($me->gender == 'male') selected @endif>{{ __('Male') }}</option>
                    <option value="female" @if ($me->gender == 'female') selected @endif>{{ __('Female') }}</option>
                </select>
                <label for="gender">{{ __('Gender') }}</label>
            </div>
            <div class="text-end">
                <button class="btn btn-primary ms-auto">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
@endsection
