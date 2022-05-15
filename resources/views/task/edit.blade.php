@extends('layouts.app')
@section('title', '修改任务')

@section('style')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-clockpicker@0.0.7/css/bootstrap-clockpicker.min.css') }}"/>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route('tasks.index') }}" title="">
                <i class="fa-solid fa-bars"></i>
                <span>任务列表</span>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route('tasks.update', $task) }}" method="post" novalidate="novalidate">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="account">打卡账号</label>
                            <select id="account" class="custom-select @error ('account') is-invalid @enderror"
                                    name="account">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('account', $task->account->id) == $account->id)>{{ $account->phone }}</option>
                                @endforeach
                            </select>
                            @error ('account')
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">打卡地址</label>
                            <select id="address" class="custom-select @error ('address') is-invalid @enderror"
                                    name="address">
                                @foreach ($addresses as $address)
                                    <option value="{{ $address->id }}" @selected(old('address', $address->id) == $address->id)>{{ $address->full_address }}</option>
                                @endforeach
                            </select>
                            @error ('address')
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">打卡类型</label>
                            <select id="type" class="custom-select" name="type">
                                @foreach (['START' => '上班', 'END' => '下班'] as $key => $value )
                                    <option value="{{ $key }}" @selected(old('type', $task->type) == $key)>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="run_role">打卡规则</label>
                            <select id="run_role" class="custom-select" name="run_role">
                                @foreach ([ 'daily' => '每天' ] as $key => $value)
                                    <option value="{{ $key }}" @selected(old('run_rule', $task->run['role']) == $key)>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="run_time">打卡时间</label>
                            <div class="input-group clockpicker">
                                <input id="run_time" class="form-control @error ('run_time') is-invalid @enderror"
                                       type="text" name="run_time" placeholder="请选择打卡时间"
                                       value="{{ old('run_time', $task->run['time']) }}"/>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                </div>
                                @error ('run_time')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">打卡备注</label>
                            <div class="input-group">
                                <textarea id="description" class="form-control" rows="3" placeholder="非必填">{{ $task->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-3 @error ('status') is-invalid @enderror" for="status">状态</label>
                            @foreach ([1 => '启用', 0 => '禁用'] as $key => $value)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input id="{{ $key }}" class="custom-control-input" type="radio" name="status"
                                           @checked(old('status', $task->status) == $key ? true : false) value="{{ $key }}"/>
                                    <label class="custom-control-label" for="{{ $key }}">{{ $value }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary" type="submit">立即修改</button>
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

            $('.clockpicker').clockpicker({
                autoclose: true
            });
        })(jQuery)
    </script>
@endsection
