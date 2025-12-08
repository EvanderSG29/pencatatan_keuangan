@extends('adminlte::page')


@section('content_header')
    <h3>@yield('page_heading')</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                @yield('card_header')
            </div>
        </div>
        <div class="card-body">
            @yield('card_body')
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop