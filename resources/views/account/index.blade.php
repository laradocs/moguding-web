@extends ( 'layouts.app' )
@section ( 'title', '账户管理' )

@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route ( 'accounts.create' ) }}" title="">
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
            @foreach ( $accounts as $account )
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->device }}</td>
                    <td>{{ $account->phone }}</td>
                    <td>{!! $account->status ? '<span class="badge badge-success">正常</span>' : '<span class="badge badge-danger">异常</span>' !!}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route ( 'accounts.edit', $account ) }}" title="">
                            <i class="fa-solid fa-sm fa-pen-to-square"></i>
                        </a>
                        <a class="btn btn-sm btn-danger btn-destroy" href="javascript:void(0);" data-id="{{ $account->id }}" title="">
                            <i class="fa-solid fa-sm fa-trash-can"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
@section ( 'script' )
    @parent
    <script>
        (function () {
            "use strict";

            $('.btn-destroy').click ( function () {
                var self = $(this);
                swal.fire ( {
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

                        return $.ajax ( {
                            type: 'DELETE',
                            url: '/accounts/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: ( response ) => {
                                swal.fire ( {
                                    icon: 'success',
                                    text: response.message,
                                    confirmButtonText: '确定'
                                } );
                                self.closest('tr').remove();
                            },
                            error: ( error ) => {
                                swal.fire ( {
                                    icon: 'error',
                                    text: error.responseJSON.message,
                                    confirmButtonText: '确定'
                                } );
                            }
                        } );
                    }
                } )
            } );
        })(jQuery)
    </script>
@stop
