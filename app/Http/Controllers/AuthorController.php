<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Qtests;

class AuthorController extends Controller
{
    public function list(Request $request)
    {
        $page = $request->page;
        $service = new Qtests();
        $authors = $service->authors($page);

        return view('dashboard.authors.list', compact('authors'));
    }
    public function single(Request $request, $author_id)
    {
        $service = new Qtests();
        $authorQuery = $service->author($author_id);

        $author = $authorQuery->data;

        return view('dashboard.authors.single', compact('author'));
    }
}
