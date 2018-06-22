@extends('layouts.base')

@section('base')

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <h3>Ada</h3>
                                </span>
                            </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            Ada
                        </div>
                    </li>

                        <li @if (Route::is('ada*')) class="active" @endif >
                            <a href="#"><i class="fa fa-rmb"></i> <span class="nav-label">Ada~</span><span
                                        class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li @if (Route::is('ada.data')) class="active" @endif>
                                    <a href="{{ route('ada.data') }}">导入数据整理</a>
                                </li>

                                <li @if (Route::is('ada.spread*')) class="active" @endif>
                                    <a href="{{ route('ada.spread') }}">推广费用</a>
                                </li>

                                <li @if (Route::is('ada.deliver*')) class="active" @endif>
                                    <a href="{{ route('ada.deliver') }}">快递数量</a>
                                </li>


                                <li @if (Route::is('ada.data.unitPrice')) class="active" @endif>
                                    <a href="{{ route('ada.data.unitPrice') }}">单价列表</a>
                                </li>

                                <li @if (Route::is('ada.shop*')) class="active" @endif>
                                    <a href="{{ route('ada.shop') }}">店铺列表</a>
                                </li>

                                <li @if (Route::is('ada.data.loadStatus')) class="active" @endif>
                                    <a href="{{ route('ada.data.loadStatus') }}">导入数据状态</a>
                                </li>
                            </ul>
                        </li>

                </ul>

            </div>
        </nav>

        @yield('side-nav')

    </div>

@endsection