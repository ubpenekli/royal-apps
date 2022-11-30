@extends('layouts.master')
@section('title')
    Authors
@endsection
@section('main')
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Author Name') }}</th>
                    <th>{{ __('Gender') }}</th>
                    <th>{{ __('Birthday') }}</th>
                    <th>{{ __('Place of Birth') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors->data->items as $author)
                    <tr>
                        <td>{{ $author->first_name }} {{ $author->last_name }}</td>
                        <td>{{ Str::studly($author->gender) }}</td>
                        <td>{{ $author->first_name }}</td>
                        <td>{{ $author->first_name }}</td>
                        <td>
                            <a href="{{ route('dashboard.authors.single', $author->id) }}" class="btn btn-primary"><i
                                    class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">{{ __('There is no authors to list here.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
