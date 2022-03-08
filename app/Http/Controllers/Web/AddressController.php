<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Repositories\AddressRepository;

class AddressController extends Controller
{
    protected AddressRepository $addresses;

    public function __construct ( AddressRepository $addresses )
    {
        $this->addresses = $addresses;
    }

    public function index()
    {
        $addresses = $this->addresses->getByUserIdOrderLatest($this->getCurrentUserId());

        return view ( 'address.index', compact ( 'addresses' ) );
    }

    public function create()
    {
        return view ( 'address.create' );
    }

    public function store ( AddressRequest $request )
    {
        $this->addresses->createOrUpdate(
            $this->getCurrentUserId(),
            $request->all()
        );
        session()->flash ( 'success', '添加成功！' );

        return redirect()->route ( 'accounts.index' );
    }
}
