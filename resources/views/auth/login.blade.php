@extends ( 'layouts.guest' )
@section ( 'title', '用户登录' )

@section ( 'content' )
    <form action="{{ route('login') }}" method="post" novalidate="novalidate">
        @csrf
        <div class="form-group">
            <label for="email">邮箱</label>
            <input id="email" class="form-control @error ('email') is-invalid @enderror" type="email" name="email"
                   placeholder="请输入邮箱" required="required" autocomplete="off" value="{{ old('email') }}" />
            @error ('email')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">密码</label>
            <input id="password" class="form-control @error ('password') is-invalid @enderror" type="password"
                   name="password" placeholder="请输入密码" required="required" autocomplete="off" value="{{ old('password') }}" />
            @error ('password')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                <input id="remember" class="custom-control-input" type="checkbox" name="remember">
                <label class="custom-control-label" for="remember">保持会话</label>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">立即登录</button>
        </div>
    </form>
    <hr />
    <div class="text-center">
        <a class="font-weight-bold small" href="{{ route('register') }}" title="">还没有账号？</a>
    </div>
@stop
