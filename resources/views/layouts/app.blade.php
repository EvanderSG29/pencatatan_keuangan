@extends('adminlte::page')

@section('content_header')
    <h3 class="text-dark">@yield('page_heading')</h3>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm border-0 rounded">
            <div class="card-header bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    @yield('card_header')
                </div>
            </div>

            <div class="card-body">
                @yield('card_body')
            </div>
        </div>
    </div>
@stop
