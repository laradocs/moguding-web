@extends ( 'layouts.app' )
@section ( 'title', '任务管理' )

@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route ( 'tasks.create' ) }}" title="">
                <i class="fa-solid fa-plus"></i>
                <span>添加任务</span>
            </a>
        </div>
        <table id="table" data-toggle="table">
            <thead>
            <tr>
                <th data-sortable="true" data-field="id">ID</th>
                <th data-field="phone">打卡账号</th>
                <th data-field="full_name">打卡地址</th>
                <th data-field="type">打卡类型</th>
                <th data-field="run_time">运行时间</th>
                <th data-field="description">打卡备注</th>
                <th data-field="status">状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ( $tasks as $task )
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->account->phone }}</td>
                    <td>{{ $task->address->full_address }}</td>
                    <td>
                        @switch ( $task->type )
                            @case ( 'START' )
                                <span class="badge badge-primary">上班</span>
                            @break
                            @case ( 'END' )
                                <span class="badge badge-info">下班</span>
                            @break
                            @default
                                <span class="badge badge-danger">未知</span>
                            @break
                        @endswitch
                    </td>
                    <td>
                        <i class="fa-solid fa-clock"></i>
                        <span>每天 {{ $task->run [ 'run_time' ] }}</span>
                    </td>
                    <td>{{ $task->desciption }}</td>
                    <td>{!! $task->status ? '<span class="badge badge-success">启用</span>' : '<span class="badge badge-danger">禁用</span>' !!}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route ( 'tasks.edit', $task ) }}" title="">
                            <i class="fa-solid fa-sm fa-pen-to-square"></i>
                        </a>
                        <a class="btn btn-sm btn-danger btn-destroy" href="javascript:void(0);" data-id="{{ $task->id }}" title="">
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
                    text: '您确定要删除此任务吗？',
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
                            url: '/tasks/' + id,
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
