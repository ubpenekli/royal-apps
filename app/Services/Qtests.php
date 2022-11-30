<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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
                'message' => __('You are logged in successfully.')
            ]);
        } else {
            return (object) ([
                'success' => false,
                'token' => null,
                'message' => __('Your credentials are not valid.'),
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
                'message' => __('Token is invalid.'),
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
                'message' => __('Token is invalid.'),
                'data' => null,
            ]);
        }
    }

    public function storeAuthor($authorRequest)
    {
        $response = $this->http->withToken($this->token_key)->post('/authors', [
            'first_name' => $authorRequest->first_name,
            'last_name' => $authorRequest->last_name,
            'birthday' => \Carbon\Carbon::parse($authorRequest->birthday)->toIso8601ZuluString(),
            'gender' => $authorRequest->gender == 'm' ? 'male' : ($authorRequest->gender == 'f' ? 'female' : ''),
            'place_of_birth' => $authorRequest->place_of_birth,
            'biography' => $authorRequest->biography
        ]);
        if ($response->ok()) {
            return (object) ([
                'success' => true,
                'message' => __('Author created successfully.')
            ]);
        } else {
            return (object) ([
                'success' => false,
                'message' => __('API error.') . json_encode($response->body())
            ]);
        }
    }

    public function storeBook($bookRequest)
    {
        $response = $this->http->withToken($this->token_key)->post('/books', [
            'author' => [
                'id' => $bookRequest->author_id,
            ],
            'title' => $bookRequest->title,
            'release_date' => \Carbon\Carbon::parse($bookRequest->release_date)->toIso8601ZuluString(),
            'description' => $bookRequest->description,
            'isbn' => $bookRequest->isbn,
            'format' => $bookRequest->format,
            'number_of_pages' => (int)$bookRequest->number_of_pages
        ]);
        if ($response->ok()) {
            return (object) ([
                'success' => true,
                'message' => __('Book created successfully.')
            ]);
        } else {
            return (object) ([
                'success' => false,
                'message' => __('API error.')
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
                    'message' => __('Author deleted successfully.')
                ]);
            } else {
                return (object) ([
                    'success' => false,
                    'message' => __('API error.')
                ]);
            }
        } else {
            return (object) ([
                'success' => false,
                'message' => __('Author cannot be deleted because the author has books.')
            ]);
        }
    }

    public function removeBook($book_id)
    {
        if ($this->http->withToken($this->token_key)->delete('/books/' . $book_id)->ok()) {
            return (object) ([
                'success' => true,
                'message' => __('Book deleted successfully.')
            ]);
        } else {
            return (object) ([
                'success' => false,
                'message' => __('API error.')
            ]);
        }
    }
}
