<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Qtests
{
    private $http;
    private $token_key;

    public function __construct()
    {
        $this->http = Http::baseUrl(config('qtests.base'));
    }

    public function getToken($email, $password)
    {
        $response = $this->http->post('/token', [
            'email' => $email,
            'password' => $password
        ]);

        if ($response->status() === 200) {
            return (object) ([
                'success' => true,
                'token' => $response->object(),
                'message' => 'You are logged in successfully.'
            ]);
        } else {
            return (object) ([
                'success' => false,
                'token' => null,
                'message' => 'Your credentials are not valid.',
                'data' => $response
            ]);
        }
    }

    public function setToken($token_key)
    {
        $this->token_key = $token_key;
    }

    public function authors()
    {
        $response = $this->http->withToken($this->token_key)->get('/authors');
        if ($response->ok() && $response->status() === 200) {
            return (object) ([
                'success' => true,
                'message' => null,
                'data' => $response->object()
            ]);
        } else {
            return (object) ([
                'success' => false,
                'message' => 'Token is invalid.',
                'data' => null,
            ]);
        }
    }

    public function author($author_id)
    {
        $response = $this->http->withToken($this->token_key)->get('/author/' . $author_id);
        if ($response->ok() && $response->status() === 200) {
            return (object) ([
                'success' => true,
                'message' => null,
                'data' => $response->object()
            ]);
        } else {
            return (object) ([
                'success' => false,
                'message' => 'Token is invalid.',
                'data' => null,
            ]);
        }
    }

    public function removeAuthor($author_id)
    {
        $author = $this->author($author_id);
        $books = (object) ($author['data']->books);
        if ($books->isNotEmpty()) {
            if ($this->http->delete('/authors/' . $author_id)->ok()) {
                return (object) ([
                    'success' => true,
                    'message' => null
                ]);
            } else {
                return (object) ([
                    'success' => false,
                    'message' => 'Deleting action failed on API server.'
                ]);
            }
        } else {
            return (object) ([
                'success' => false,
                'message' => 'Author cannot be deleted because the author has books.'
            ]);
        }
    }

    public function removeBook($book_id)
    {
        if ($this->http->delete('/books/' . $book_id)->ok()) {
            return (object) ([
                'success' => true,
                'message' => null
            ]);
        } else {
            return (object) ([
                'success' => false,
                'message' => 'Deleting action failed on API server.'
            ]);
        }
    }
}
