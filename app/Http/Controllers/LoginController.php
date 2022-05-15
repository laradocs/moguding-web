<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
        $this->middleware('auth')->only('destroy');
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt($validated, $request->has('remember'))) {
            session()->flash('success', '登录成功！');

            return redirect()->intended(route('dashboard'));
        }
        session()->flash('error', '很抱歉，您的邮箱和密码不匹配。');

        return back()->withInput();
    }

    public function destroy()
    {
        Auth::logout();

        return response()->json([
            'message' => '退出成功！',
            'redirect_url' => route('login'),
        ]);
    }
}
