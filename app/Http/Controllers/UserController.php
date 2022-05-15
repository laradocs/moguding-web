<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->middleware('auth')->except('create', 'store');
        $this->middleware('guest')->only('create', 'store');

        $this->users = $users;
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->users->updateOrCreate($request->all());
        Auth::login($user);

        return redirect()->intended(route('dashboard', compact('user')));
    }
}
