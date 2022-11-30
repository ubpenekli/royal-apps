<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookStoreRequest;
use App\Services\Qtests;

class BookController extends Controller
{
    public function create()
    {
        $service = new Qtests();
        $authorsQuery = $service->authors();
        $total_pages = $authorsQuery->data->total_pages;
        $authors = collect($authorsQuery->data->items);
        for ($i = 2; $i <= $total_pages; $i++) {
            $authors = $authors->merge($service->authors($i)->data->items);
        }
        return view('dashboard.books.create', compact('authors'));
    }
    public function store(BookStoreRequest $bookStoreRequest)
    {
        $service = new Qtests();
        $response = $service->storeBook($bookStoreRequest->safe());

        return redirect()->back()->with('message', $response->message);
    }
    public function delete($book_id)
    {
        $service = new Qtests();
        $response = $service->removeAuthor($book_id);

        return redirect()->back()->with('message', $response->message);
    }
}
