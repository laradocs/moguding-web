<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
}
