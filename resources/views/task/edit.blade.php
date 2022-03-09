@extends ( 'layouts.app' )
@section ( 'title', '添加任务' )

@section ( 'style' )
    @parent
    <link rel="stylesheet" href="{{ asset ( 'assets/bootstrap-clockpicker@0.0.7/css/bootstrap-clockpicker.min.css' ) }}" />
@endsection
@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route ( 'tasks.index' ) }}" title="">
                <i class="fa-solid fa-bars"></i>
                <span>任务列表</span>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route ( 'tasks.update', $task ) }}" method="post" novalidate="novalidate">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="account_id">打卡账号</label>
                            <select id="account_id" class="custom-select @error ( 'account_id' ) is-invalid @enderror" name="account_id">
                                @foreach ( $accounts as $account )
                                    <option value="{{ $account->id }}" {{ $account->id === $task->account_id ? 'selected' : '' }} {{ old ( 'account_id' ) === $account->id ? 'selected' : '' }}>{{ $account->phone }}</option>
                                @endforeach
                            </select>
                            @error ( 'account_id' )
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address_id">打卡地址</label>
                            <select id="address_id" class="custom-select @error ( 'account_id' ) is-invalid @enderror" name="address_id">
                                @foreach ( $addresses as $address )
                                    <option value="{{ $address->id }}" {{ $address->id === $task->address_id ? 'selected' : '' }} {{ old ( 'address_id' ) === $address->id ? 'selected' : '' }}>{{ $address->full_address }}</option>
                                @endforeach
                            </select>
                            @error ( 'address_id' )
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">打卡类型</label>
                            <select id="type" class="custom-select @error ( 'type' ) is-invalid @enderror" name="type">
                                @foreach ( [ 'START' => '上班', 'END' => '下班'] as $key => $value )
                                    <option value="{{ $key }}" {{ $key === $task->type ? 'selected' : '' }} {{ old ( 'type' ) === $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error ( 'type' )
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="run_role">打卡规则</label>
                            <select id="run_role" class="custom-select @error ( 'run_rule' ) is-invalid @enderror" name="run_role">
                                @foreach ( [ 'daily' => '每天' ] as $key => $value )
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="run_time">打卡时间</label>
                            <div class="input-group clockpicker">
                                <input id="run_time" class="form-control @error ( 'run_time' ) is-invalid @enderror" type="text" name="run_time" placeholder="请选择打卡时间" value="{{ old ( 'run_time', $task->run [ 'runTime' ] ) }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                </div>
                            </div>
                            @error ( 'run_time' )
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">打卡备注</label>
                            <div class="input-group">
                                <textarea id="description" class="form-control" rows="3" placeholder="非必填">{{ old ( 'description', $task->description ) }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-3" for="status">状态</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="on" class="custom-control-input" type="radio" name="status" {{ $task->status == 1 ? 'checked' : '' }} value="1" />
                                <label class="custom-control-label" for="on">启用</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="off" class="custom-control-input" type="radio" name="status"  {{ $task->status == 0 ? 'checked' : '' }}  value="0" />
                                <label class="custom-control-label" for="off">禁用</label>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="立即添加" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section ( 'script' )
    @parent
    <script src="{{ asset ( 'assets/bootstrap-clockpicker@0.0.7/js/bootstrap-clockpicker.min.js' ) }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('.clockpicker').clockpicker ( {
                autoclose: true
            } );
        })(jQuery)
    </script>
@endsection
