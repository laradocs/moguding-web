<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\AccountRepository;
use App\Repositories\AddressRepository;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    protected TaskRepository $tasks;

    public function __construct ( TaskRepository $tasks )
    {
        $this->tasks = $tasks;
    }

    public function index()
    {
        $tasks = $this->tasks->getByUserIdOrderLatest($this->getCurrentUserId());
        $tasks->load ( [ 'account:id,phone', 'address:id,province,city,address' ] );

        return view ( 'task.index', compact ( 'tasks' ) );
    }

    public function create()
    {
        /** @var AccountRepository $accountRepository */
        $accountRepository = app ( AccountRepository::class );
        $accounts = $accountRepository->getByUserIdOrderLatest($this->getCurrentUserId(), [ 'id', 'phone' ]);
        /** @var AddressRepository $addressRepository */
        $addressRepository = app ( AddressRepository::class );
        $addresses = $addressRepository->getByUserIdOrderLatest($this->getCurrentUserId(), [ 'id', 'province', 'city', 'address' ]);

        return view ( 'task.create', compact ( 'accounts', 'addresses' ) );
    }

    public function store ( TaskRequest $request )
    {
        $this->tasks->createOrUpdate($this->getCurrentUserId(), $request->all());
        session()->flash ( 'success', '添加成功！' );

        return redirect()->route ( 'tasks.index' );
    }

    public function edit ( int $id )
    {
        /** @var AccountRepository $accountRepository */
        $accountRepository = app ( AccountRepository::class );
        $accounts = $accountRepository->getByUserIdOrderLatest($this->getCurrentUserId(), [ 'id', 'phone' ]);
        /** @var AddressRepository $addressRepository */
        $addressRepository = app ( AddressRepository::class );
        $addresses = $addressRepository->getByUserIdOrderLatest($this->getCurrentUserId(), [ 'id', 'province', 'city', 'address' ]);
        $task = $this->tasks->findOrFailById($id, $this->getCurrentUserId());

        return view ( 'task.edit', compact ( 'task', 'accounts', 'addresses' ) );
    }

    public function update ( TaskRequest $request, int $id )
    {
        $this->tasks->createOrUpdate(
            $this->getCurrentUserId(),
            $request->all(),
            $id
        );
        session()->flash (  'success', '修改成功！' );

        return redirect()->route ( 'tasks.index' );
    }

    public function destroy ( int $id )
    {
        $this->tasks->delete($id, $this->getCurrentUserId());

        return response()->json ( [
            'message' => '删除成功！',
        ] );
    }
}
