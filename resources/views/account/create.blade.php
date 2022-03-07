@extends ( 'layouts.app' )
@section ( 'title', '添加账户' )

@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route ( 'accounts.index' ) }}" title="">
                <i class="fa-solid fa-bars"></i>
                <span>账户列表</span>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route ( 'accounts.store' ) }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <label for="device">设备</label>
                            <select id="device" class="custom-select" name="device">
                                <option value="">请选择设备</option>
                                <option value="android" {{ old ( 'device' ) == 'android' ? 'selected' : '' }}>安卓</option>
                                <option value="ios" {{ old ( 'device' ) == 'ios' ? 'selected' : '' }}>苹果</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">手机号码</label>
                            <input id="phone" class="form-control" type="text" name="phone" placeholder="请输入手机号码" required="required" value="{{ old ( 'phone' ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input id="password" class="form-control" type="password" name="password" placeholder="请输入密码" required="required" value="{{ old ( 'password' ) }}" />
                        </div>
                        <input class="btn btn-primary" type="submit" value="立即添加" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
