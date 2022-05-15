<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Laradocs\Moguding\MogudingResolverInterface;

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
        /** @var MogudingResolverInterface $moguding */
        $moguding = app(MogudingResolverInterface::class);
        try {
            $moguding->login($account->device, $account->phone, $account->password);
        } catch (Exception $e) {
            $accounts->updateStatus($accountId, false);
            throw new BusinessException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
        $accounts->updateStatus($accountId, true);

        return response()->json([
            'message' => '测试通过！',
        ], Response::HTTP_ACCEPTED);
    }
}
