<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
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
       $accounts = $this->accounts->getByUserId($this->getCurrentUserId());

        return view ( 'account.index', compact ( 'accounts' ) );
    }

    public function create()
    {
        return view ( 'account.create' );
    }

    public function store ( AccountRequest $request )
    {
        try {
            $user = app('moguding')->login (
                $request->device,
                $request->phone,
                $request->password
            );
        } catch ( RequestTimeoutException|UnauthenticatedException $e ) {
            session()->flash ( 'error', $e->getMessage() );

            return back()->withInput();
        }
        $this->accounts->createOrUpdate(
            $this->getCurrentUserId(),
            $request->all()
        );
        session()->flash ( 'success', '添加成功！' );

        return redirect()->route ( 'accounts.index' );
    }

    public function destroy ( int $id )
    {
        $this->accounts->delete($id);

        return response()->json ( [
            'message' => '删除成功！',
        ] );
    }
}
