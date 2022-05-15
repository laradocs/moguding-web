@extends ( 'layouts.app' )
@section ( 'title', '添加账户' )

@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route('accounts.index') }}" title="">
                <i class="fa-solid fa-bars"></i>
                <span>账户列表</span>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route('accounts.store') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <label for="device">设备</label>
                            <select id="device" class="custom-select @error ('device') is-invalid @enderror" name="device">
                                <option value="">请选择设备</option>
                                @foreach (['android' => '安卓', 'ios' => '苹果'] as $key => $device)
                                    <option value="{{ $key }}" @selected(old('device') === $key)>{{ $device }}</option>
                                @endforeach
                            </select>
                            @error ('device')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">手机号码</label>
                            <input id="phone" class="form-control @error ('phone') is-invalid @enderror" type="text"
                                   name="phone" placeholder="请输入手机号码" required="required"
                                   value="{{ old('phone') }}" />
                            @error ('phone')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input id="password" class="form-control @error ('password') is-invalid @enderror"
                                   type="password" name="password" placeholder="请输入密码" required="required" value="{{ old('password') }}" />
                            @error ('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">立即添加</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
