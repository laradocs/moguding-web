<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    }
}
