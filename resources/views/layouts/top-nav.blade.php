@extends('layouts.base')

@section('base')

<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <i class="fa fa-reorder"></i>
                    </button>
                    <a href="{{ route('home') }}" class="navbar-brand"> {{ trans(config('app.name')) }} </a>
                </div>
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a aria-expanded="false" role="button" href="{{ route('home') }}">{{ trans('app.首页') }}</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        @yield('top-nav')

        @include('layouts.footer')

    </div>
</div>

@endsection
