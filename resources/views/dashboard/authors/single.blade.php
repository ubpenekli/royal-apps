@extends('layouts.master')
@section('title')
    {{ $author->first_name . ' ' . $author->last_name }}
@endsection
@section('main')
    <div class="container">
        <h1>{{ $author->first_name }} {{ $author->last_name }}</h1>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>{{ __('ISBN') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Release Date') }}</th>
                    <th>{{ __('Format') }}</th>
                    <th>{{ __('Number of Pages') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($author->books as $book)
                    <tr>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->release_date }}</td>
                        <td>{{ $book->format }}</td>
                        <td>{{ $book->number_of_pages }}</td>
                        <td>
                            <a href="{{ route('dashboard.books.delete', $book->id) }}" class="btn btn-danger"><i
                                    class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">{{ __('There is no books to list here.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
