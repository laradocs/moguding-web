@extends ( 'layouts.app' )
@section ( 'title', '账户管理' )

@section ( 'content' )
    @include ( 'layouts._header' )

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
                    <a class="btn btn-sm btn-info" href="" title="">
                        <i class="fa-solid fa-sm fa-pen-to-square"></i>
                    </a>
                    <a class="btn btn-sm btn-danger" href="javascript:void(0);" title="">
                        <i class="fa-solid fa-sm fa-trash-can"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
