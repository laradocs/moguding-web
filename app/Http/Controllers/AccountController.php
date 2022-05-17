<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Requests\AccountRequest;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AccountController extends Controller
{
    protected AccountRepository $accounts;

    public function __construct(AccountRepository $accounts)
    {
        $this->middleware('auth');

        $this->accounts = $accounts;
    }

    public function index()
    {
        $accounts = $this->accounts->get(Auth::id());

        return view('account.index', compact('accounts'));
    }

    public function create()
    {
        return view('account.create');
    }

    public function store(AccountRequest $request)
    {
        $this->accounts->updateOrCreate(Auth::id(), $request->all());
        session()->flash('success', '添加成功！');

        return redirect()->intended(route('accounts.index'));
    }

    public function edit(int $id)
    {
        $account = $this->accounts->find($id, true);
        if (! Gate::allows('own', $account)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }

        return view('account.edit', compact('account'));
    }

    public function update(AccountRequest $request, int $id)
    {
        $this->accounts->updateOrCreate(Auth::id(), $request->all(), $id);
        session()->flash('success', '修改成功！');

        return redirect()->intended(route('accounts.index'));
    }

    public function destroy(int $id)
    {
        $this->accounts->delete($id);

        return response()->json([
            'message' => '删除成功！',
        ]);
    }
}
