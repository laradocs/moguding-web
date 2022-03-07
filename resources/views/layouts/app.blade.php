<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield ( 'title' ) - {{ config ( 'app.name' ) }}</title>
    @section ( 'style' )
        <link rel="stylesheet" href="{{ asset ( 'assets/bootstrap@4.6.1/css/bootstrap.min.css' ) }}" />
        <link rel="stylesheet" href="{{ asset ( 'assets/bootstrap-table@1.19.1/css/bootstrap-table.min.css' ) }}">
        <link rel="stylesheet" href="{{ asset ( 'assets/fontawesome@6.0.0/css/fontawesome.min.css' ) }}" />
        <link rel="stylesheet" href="{{ asset ( 'assets/toastr@2.1.1/css/toastr.min.css' ) }}" />
        <link rel="stylesheet" href="{{ asset ( 'assets/sweetalert2@11.4.4/css/sweetalert2.min.css' ) }}" />
        <link rel="stylesheet" href="{{ asset ( 'css/app.css' ) }}" />
    @show
</head>
<body id="page-top">

<div id="wrapper">
    @include ( 'layouts._sidebar' )
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include ( 'layouts._topbar' )
            <div class="container-fluid" id="container-wrapper">
                @include ( 'layouts._header' )
                @yield ( 'content' )
            </div>
        </div>
    </div>
</div>
@include ( 'layouts._scroll-to-top' )

@section ( 'script' )
    <script src="{{ asset ( 'assets/jquery@3.6.0/js/jquery.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/jquery.easing@1.4.1/js/jquery.easing.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/popper@2.11.2/js/popper.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/bootstrap@4.6.1/js/bootstrap.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/bootstrap-table@1.19.1/js/bootstrap-table.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/bootstrap-table@1.19.1/js/bootstrap-table-zh-CN.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/toastr@2.1.1/js/toastr.min.js' ) }}"></script>
    <script src="{{ asset ( 'assets/sweetalert2@11.4.4/js/sweetalert2.min.js' ) }}"></script>
    <script src="{{ asset ( 'js/app.min.js' ) }}"></script>
    @include ( 'shared._messages' )
    <script>
        (function ($) {
            "use strict";

            $('#logout').click ( function () {
                swal.fire ( {
                    icon: 'question',
                    text: '您确定要退出登录吗？',
                    confirmButtonText: '确定',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax ( {
                            type: 'DELETE',
                            url: '{{ route ( 'logout' ) }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: ( response ) => {
                                swal.fire ( {
                                    icon: 'success',
                                    text: response.message,
                                    confirmButtonText: '确定'
                                } ).then ( () => {
                                    window.location.replace ( response.uri );
                                } );
                            },
                            error: ( error ) => {
                                swal.fire ( {
                                    icon: 'error',
                                    text: '服务器繁忙，请稍后重试。',
                                    confirmButtonText: '确定'
                                } );
                            }
                        } );
                    }
                } );
            } );

            $('#table').bootstrapTable();
        })(jQuery);
    </script>
@show

</body>
</html>
