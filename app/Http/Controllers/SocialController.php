<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Gate;

class SocialController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth');
    }

    public function store(int $accountId)
    {
        /** @var AccountRepository $accounts */
        $accounts = app(AccountRepository::class);
        $account = $accounts->find($accountId, true);
        if (! Gate::allows('own', $account)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }
        try {
            app('moguding')->login($account->device, $account->phone, $account->password);
        } catch (Exception $e) {
            $accounts->updateStatus($accountId, false);
            throw new BusinessException($e->getMessage() ?? '请求超时！', Response::HTTP_UNAUTHORIZED);
        }
        $accounts->updateStatus($accountId, true);

        return response()->json([
            'message' => '测试通过！',
        ], Response::HTTP_ACCEPTED);
    }
}
