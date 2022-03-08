<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected UserRepository $users;

    public function __construct ( UserRepository $users )
    {
        $this->users = $users;
    }

    public function create()
    {
        return view ( 'auth.register' );
    }

    public function store ( RegisterRequest $request )
    {
        $user = $this->users->createOrUpdate($request->all());
        Auth::login ( $user );
        $dashboard = route ( 'dashboard' );
        session()->flash ( 'success', '注册成功！' );

        return redirect()->intended ( $dashboard );
    }
}
