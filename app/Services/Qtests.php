<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Qtests
{
    private $http;

    public function __construct()
    {
        $this->http = Http::baseUrl(config('qtests.base'));
    }

    public function getToken()
    {
        $user = $this->http->post('/authentication', [
            'email' => config('qtests.email'),
            'password' => config('qtests.pass')
        ])->object();

        return $user->token_key;
    }

    public function authors()
    {
        return $this->http->get('/authors')->object();
    }

    public function author($author_id)
    {
        return $author = $this->http->get('/authors/' . $author_id)->object();
    }

    public function removeAuthor($author_id)
    {
        $author = $this->author($author_id);
        $books = collect($author->books);
        if ($books->isNotEmpty()) {
            if ($this->http->delete('/authors/' . $author_id)->ok()) {
                return [
                    'success' => true,
                    'message' => null
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Deleting action failed on API server.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Author cannot be deleted because the author has books.'
            ];
        }
    }

    public function removeBook($book_id)
    {
        if ($this->http->delete('/books/' . $book_id)->ok()) {
            return [
                'success' => true,
                'message' => null
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Deleting action failed on API server.'
            ];
        }
    }
}
