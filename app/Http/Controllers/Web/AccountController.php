<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Repositories\AccountRepository;
use Laradocs\Moguding\Exceptions\RequestTimeoutException;
use Laradocs\Moguding\Exceptions\UnauthenticatedException;

class AccountController extends Controller
{
    protected AccountRepository $accounts;

    public function __construct ( AccountRepository $accounts )
    {
        $this->accounts = $accounts;
    }

    public function index()
    {
       $accounts = $this->accounts->getByUserIdOrderLatest($this->getCurrentUserId());

        return view ( 'account.index', compact ( 'accounts' ) );
    }

    public function create()
    {
        return view ( 'account.create' );
    }

    public function store ( AccountRequest $request )
    {
        $attributes = $request->all();
        try {
            app('moguding')->login (
                $attributes [ 'device' ],
                $attributes [ 'phone' ],
                $attributes [ 'password' ]
            );
        } catch ( RequestTimeoutException|UnauthenticatedException $e ) {
            session()->flash ( 'error', $e->getMessage() );

            return back()->withInput();
        }
        $this->accounts->createOrUpdate(
            $this->getCurrentUserId(),
            $attributes
        );
        session()->flash ( 'success', '添加成功！' );

        return redirect()->route ( 'accounts.index' );
    }

    public function edit ( int $id )
    {
        $account = $this->accounts->findOrFailById($id, $this->getCurrentUserId());

        return view ( 'account.edit', compact ( 'account' ) );
    }

    public function update ( AccountRequest $request, int $id )
    {
        $attributes = $request->all();
        try {
            app('moguding')->login (
                $attributes [ 'device' ],
                $attributes [ 'phone' ],
                $attributes [ 'password' ]
            );
        } catch ( RequestTimeoutException|UnauthenticatedException $e ) {
            session()->flash ( 'error', $e->getMessage() );

            return back()->withInput();
        }
        $this->accounts->createOrUpdate(
            $this->getCurrentUserId(),
            $attributes,
            $id
        );
        session()->flash ( 'success', '修改成功！' );

        return redirect()->route ( 'accounts.index' );
    }

    public function destroy ( int $id )
    {
        $this->accounts->delete($id, $this->getCurrentUserId());

        return response()->json ( [
            'message' => '删除成功！',
        ] );
    }
}
