@extends('layouts.master')
@section('title')
    {{ __('Authors') }}
@endsection
@section('main')
    <div class="container">
        <h1>{{ __('Authors') }}</h1>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>{{ __('Author Name') }}</th>
                    <th>{{ __('Gender') }}</th>
                    <th>{{ __('Birthday') }}</th>
                    <th>{{ __('Place of Birth') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors->data->items as $author)
                    <tr>
                        <td>{{ $author->first_name }} {{ $author->last_name }}</td>
                        <td>{{ Str::studly($author->gender) }}</td>
                        <td>{{ \Carbon\Carbon::parse($author->birthday)->format('F jS, Y') }}</td>
                        <td>{{ $author->place_of_birth }}</td>
                        <td class="text-end">
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
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                @if ($authors->data->current_page !== 1)
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif
                @for ($i = 1; $i <= $authors->data->total_pages; $i++)
                    <li class="page-item @if ($authors->data->current_page == $i) active @endif"
                        @if ($authors->data->current_page === $i) aria-current="page" @endif><a class="page-link"
                            href="@if ($authors->data->current_page !== $i) {{ route('dashboard.authors.list', ['page' => $i]) }} @else # @endif">{{ $i }}</a>
                    </li>
                @endfor
                @if ($authors->data->current_page !== $authors->data->total_pages)
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
