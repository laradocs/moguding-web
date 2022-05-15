<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Repositories\AccountRepository;
use App\Repositories\AddressRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected TaskRepository $tasks;

    protected AccountRepository $accounts;

    protected AddressRepository $addresses;

    public function __construct(TaskRepository $tasks, AccountRepository $accounts, AddressRepository $addresses)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
        $this->accounts = $accounts;
        $this->addresses = $addresses;
    }

    public function index()
    {
        $tasks = $this->tasks->get(Auth::id());

        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $accounts = $this->accounts->get(Auth::id());
        $addresses = $this->addresses->get(Auth::id());

        return view('task.create', compact('accounts', 'addresses'));
    }

    public function store(TaskRequest $request)
    {
        $this->tasks->updateOrCreate(Auth::id(), $request->all());
        session()->flash('success', '添加成功！');

        return redirect()->intended(route('tasks.index'));
    }

    public function edit(int $id)
    {
        $task = $this->tasks->find($id, true);
        $accounts = $this->accounts->get(Auth::id());
        $addresses = $this->addresses->get(Auth::id());

        return view('task.edit', compact('task', 'accounts', 'addresses'));
    }

    public function update(TaskRequest $request, int $id)
    {
        $this->tasks->updateOrCreate(Auth::id(), $request->all(), $id);
        session()->flash('success', '修改成功！');

        return redirect()->intended(route('tasks.index'));
    }

    public function destroy(int $id)
    {
        $this->tasks->delete($id);

        return response()->json([
            'message' => '删除成功！',
        ]);
    }
}
