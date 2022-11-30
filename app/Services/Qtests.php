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
        $user = session('user');
        if ($user !== null) {
            $this->setToken($user->token_key);
        }
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

    public function authors($page = 1)
    {
        $response = $this->http->withToken($this->token_key)->get('/authors', [
            'page' => $page,
            'limit' => 5
        ]);
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
        $response = $this->http->withToken($this->token_key)->get('/authors/' . $author_id);

        if ($response->ok()) {
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
            if ($this->http->withToken($this->token_key)->delete('/authors/' . $author_id)->ok()) {
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
        if ($this->http->withToken($this->token_key)->delete('/books/' . $book_id)->ok()) {
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
