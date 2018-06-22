@extends('layouts.data-center')

@section('side-nav')

<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">

            </ul>

        </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">

        @section('page-head')

        <div class="col-sm-4 tooltip-demo">
            <h2>
                {{ $title }}
                {!! BaseHtml::about(Route::currentRouteName()) !!}
            </h2>
        </div>
        @show

    </div>


    <div class="wrapper wrapper-content animated fadeInRight">

        @yield('content')

    </div>

    @include('layouts.footer')

</div>

@endsection
