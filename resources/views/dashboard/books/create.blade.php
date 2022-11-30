@extends('layouts.master')
@section('title')
    {{ __('Create Book') }}
@endsection
@section('main')
    <div class="container">
        <h1>{{ __('Create Book') }}</h1>
        @if ($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        <form action="{{ route('dashboard.books.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-floating mb-3">
                <select name="author_id" id="author_id" class="form-control" placeholder="{{ __('Author') }}">
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                    @endforeach
                </select>
                <label for="author_id">{{ __('Author') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="title" name="title"
                    placeholder="{{ __('Book Title') }}" required autocomplete="off">
                <label for="title">{{ __('Book Title') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="date" id="release_date" name="release_date"
                    placeholder="{{ __('Release Date') }}" required required autocomplete="off">
                <label for="release_date">{{ __('Release Date') }}</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="description" name="description" placeholder="{{ __('Book Description') }}" required
                    autocomplete="off"></textarea>
                <label for="description">{{ __('Book Description') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="isbn" name="isbn" placeholder="{{ __('ISBN') }}"
                    required autocomplete="off">
                <label for="isbn">{{ __('ISBN') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="format" name="format" placeholder="{{ __('Format') }}"
                    required autocomplete="off">
                <label for="format">{{ __('Format') }}</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="number_of_pages" name="number_of_pages"
                    placeholder="{{ __('Number of Pages') }}" required autocomplete="off">
                <label for="number_of_pages">{{ __('Number of Pages') }}</label>
            </div>
            <div class="text-end">
                <button class="btn btn-primary ms-auto">{{ __('Create') }}</button>
            </div>
        </form>
    </div>
@endsection
