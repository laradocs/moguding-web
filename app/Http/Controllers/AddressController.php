<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Requests\AddressRequest;
use App\Repositories\AddressRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AddressController extends Controller
{
    protected AddressRepository $addresses;

    public function __construct(AddressRepository $addresses)
    {
        $this->middleware('auth');

        $this->addresses = $addresses;
    }

    public function index()
    {
        $addresses = $this->addresses->get(Auth::id());

        return view('address.index', compact('addresses'));
    }

    public function create()
    {
        return view('address.create');
    }

    public function store(AddressRequest $request)
    {
        $this->addresses->updateOrCreate(Auth::id(), $request->all());
        session()->flash('success', '添加成功！');

        return redirect()->intended(route('addresses.index'));
    }

    public function edit(int $id)
    {
        $address = $this->addresses->find($id, true);
        if(! Gate::allows('own', $address)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }

        return view('address.edit', compact('address'));
    }

    public function update(AddressRequest $request, int $id)
    {
        $this->addresses->updateOrCreate(Auth::id(), $request->all(), $id);
        session()->flash('success', '修改成功！');

        return redirect()->intended(route('addresses.index'));
    }

    public function destroy(int $id)
    {
        $this->addresses->delete($id);

        return response()->json([
            'message' => '删除成功！',
        ]);
    }
}
