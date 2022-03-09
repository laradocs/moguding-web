@extends ( 'layouts.app' )
@section ( 'title', '添加地址' )

@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route ( 'addresses.index' ) }}" title="">
                <i class="fa-solid fa-bars"></i>
                <span>地址列表</span>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route ( 'addresses.store' ) }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <label for="province">所在省</label>
                            <input id="province" class="form-control @error ( 'province' ) is-invalid @enderror" type="text" name="province" placeholder="请输入所在省" required="required" value="{{ old ( 'province' ) }}" />
                            @error ( 'province' )
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="city">所在市</label>
                            <input id="city" class="form-control @error ( 'city' ) is-invalid @enderror" type="text" name="city" placeholder="在「直辖市」的同学可以不用填" required="required" value="{{ old ( 'city' ) }}" />
                            @error ( 'city' )
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">详细地址（打开蘑菇丁/工学云查看定位）</label>
                            <input id="address" class="form-control @error ( 'address' ) is-invalid @enderror" type="text" name="address" placeholder="请输入详细地址" required="required" value="{{ old ( 'address' ) }}" />
                            @error ( 'address' )
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="longitude">经度 <a href="https://jingweidu.bmcx.com" target="_blank" title="">点击查询</a></label>
                            <input id="longitude" class="form-control @error ( 'longitude' ) is-invalid @enderror" type="text" name="longitude" placeholder="请输入经度" required="required" value="{{ old ( 'longitude' ) }}" />
                            @error ( 'longitude' )
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="latitude">纬度 <a href="https://jingweidu.bmcx.com" target="_blank" title="">点击查询</a></label>
                            <input id="latitude" class="form-control @error ( 'address' ) is-invalid @enderror" type="text" name="latitude" placeholder="请输入纬度" required="required" value="{{ old ( 'latitude' ) }}" />
                            @error ( 'latitude' )
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input class="btn btn-primary" type="submit" value="立即添加" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
