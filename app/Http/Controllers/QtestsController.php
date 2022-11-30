<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Qtests;

class QtestsController extends Controller
{
    public function login_view()
    {
        if (session('user')) {
            return redirect()->route('dashboard.main');
        }
        return view('login_view');
    }
    public function login(LoginRequest $loginRequest)
    {
        $login = $loginRequest->safe();
        $service = new Qtests();
        $loginResponse = $service->getToken($login->email, $login->password);

        if ($loginResponse->success) {
            $user = (object) ([
                'token_key' => $loginResponse->token->token_key,
                'expires_at' => $loginResponse->token->expires_at,
                'first_name' => $loginResponse->token->user->first_name,
                'last_name' => $loginResponse->token->user->last_name
            ]);
            session(['user' => $user]);
            return redirect()->route('dashboard.main');
        } else {
            return redirect()->back()->with('error', $loginResponse->message);
        }
    }
    public function logout()
    {
        session(['user' => null]);
        return redirect()->route('login_view');
    }
    public function dashboard()
    {
        $service = new Qtests();
        $me = $service->me()->data;
        return view('dashboard.main', compact('me'));
    }
    public function profile_update(ProfileUpdateRequest $profileUpdateRequest)
    {
        $service = new Qtests();
        $response = $service->updateProfile($profileUpdateRequest->safe());
        $me = $service->me()->data;

        $sess_user = session('user');
        $sess_user->first_name = $me->first_name;
        $sess_user->last_name = $me->last_name;
        session(['user' => $sess_user]);

        return redirect()->back()->with('message', $response->message);
    }
}
