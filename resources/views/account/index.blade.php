@extends('layouts.app')
@section('title', '账户管理')

@section('content')
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route('accounts.create') }}" title="">
                <i class="fa-solid fa-plus"></i>
                <span>添加账户</span>
            </a>
        </div>
        <table id="table" data-toggle="table">
            <thead>
            <tr>
                <th data-sortable="true" data-field="id">ID</th>
                <th data-field="device">设备</th>
                <th data-field="phone">手机号码</th>
                <th data-field="status">状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>
                        <span class="label label-{{ $account::$deviceColor[$account->device] }} label-static">
                            {{ $account::$device[$account->device] }}
                        </span>
                    </td>
                    <td>{{ $account->phone }}</td>
                    <td>
                        <span class="label label-{{ $account::$statusColor[$account->status] }}">
                            {{ $account::$status[$account->status] }}
                        </span>
                    </td>
                    <td>
                        <a class="text-primary text-decoration-none" href="{{ route('accounts.edit', $account) }}"
                           data-toggle="tooltip" title="编辑">
                            <i class="fa-solid fa-sm fa-pen-to-square"></i>
                        </a>
                        <a class="text-danger text-decoration-none destroy" href="javascript:void(0);"
                           data-id="{{ $account->id }}" title="删除">
                            <i class="fa-solid fa-sm fa-trash-can"></i>
                        </a>
                        <a class="text-info text-decoration-none socialize" href="javascript:void(0);"
                           data-id="{{ $account->id }}" title="测试">
                            <i class="fa-solid fa-sm fa-code"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
@section ('script')
    @parent
    <script>
        (function () {
            "use strict";

            $('.destroy').click(function () {
                var self = $(this);
                swal.fire({
                    icon: 'warning',
                    text: '您确定要删除此账户吗？',
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: '确定',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    showLoaderOnDeny: true,
                    preDeny: () => {
                        var id = self.data('id');

                        return $.ajax({
                            type: 'delete',
                            url: '/accounts/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (response) => {
                                swal.fire({
                                    icon: 'success',
                                    text: response.message,
                                    confirmButtonText: '确定'
                                });
                                self.closest('tr').remove();
                            },
                            error: (error) => {
                                swal.fire({
                                    icon: 'error',
                                    text: error.responseJSON.message,
                                    confirmButtonText: '确定'
                                });
                            }
                        });
                    }
                });
            });

            $('.socialize').click(function () {
                var self = $(this);
                var id = self.data('id');
                $.ajax({
                    type: 'post',
                    url: '/socialize/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (response) => {
                        swal.fire({
                            icon: 'success',
                            text: response.message,
                            confirmButtonText: '确定',
                        });
                        self.parent()
                            .prev()
                            .children()
                            .removeClass('label-danger')
                            .addClass('label-success')
                            .text('正常');
                    },
                    error: (error) => {
                        swal.fire({
                            icon: 'error',
                            text: error.responseJSON.message,
                            confirmButtonText: '确定',
                        });
                        self.parent()
                            .prev()
                            .children()
                            .removeClass('label-success')
                            .addClass('label-danger')
                            .text('异常');
                    }
                })
            });
        })(jQuery);
    </script>
@stop
