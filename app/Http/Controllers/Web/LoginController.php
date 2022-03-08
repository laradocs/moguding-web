<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view ( 'auth.login' );
    }

    public function store ( LoginRequest $request )
    {
        $credentials = $request->validated();
        if ( Auth::attempt ( $credentials, $request->has ( 'remember' ) ) ) {
            session()->flash ( 'success', '欢迎回来！' );
            $dashboard = route ( 'dashboard' );

            return redirect()->intended ( $dashboard );
        } else {
            session()->flash ( 'error', '很抱歉，您的邮箱和密码不匹配。' );

            return back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();

        return response()->json ( [
            'message' => '退出成功！',
            'uri' => route ( 'login' ),
        ] );
    }
}
