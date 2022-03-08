@extends ( 'layouts.app' )
@section ( 'title', '地址管理' )

@section ( 'content' )
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route ( 'addresses.create' ) }}" title="">
                <i class="fa-solid fa-plus"></i>
                <span>添加地址</span>
            </a>
        </div>
        <table id="table" data-toggle="table">
            <thead>
            <tr>
                <th data-sortable="true" data-field="id">ID</th>
                <th data-field="province">所在省</th>
                <th data-field="city">所在市</th>
                <th data-field="address">详细地址</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ( $addresses as $address )
                <tr>
                    <td>{{ $address->id }}</td>
                    <td>{{ $address->province }}</td>
                    <td>{{ $address->city }}</td>
                    <td>{{ $address->address }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route ( 'addresses.edit', $address ) }}" title="">
                            <i class="fa-solid fa-sm fa-pen-to-square"></i>
                        </a>
                        <a class="btn btn-sm btn-danger btn-destroy" href="javascript:void(0);" data-id="{{ $address->id }}" title="">
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
                    text: '您确定要删除此地址吗？',
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
                            url: '/addresses/' + id,
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
