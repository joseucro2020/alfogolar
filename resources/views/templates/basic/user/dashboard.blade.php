@extends($activeTemplate.'layouts.master')
@section('content')


<div class="dashboard-section padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-xl-3">
                <div class="dashboard-menu">
                    @include($activeTemplate.'user.partials.dp')
                    <ul>
                        @include($activeTemplate.'user.partials.sidebar')
                    </ul>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="row justify-content-center mb-30-none">

                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="{{route('user.orders', 'all')}}" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </span>
                                <div class="cont">
                                    @php $number = number_format_short($orders->count()) @endphp
                                    <div class="dashboard-header">
                                        <h2 class="title">{{ $number[0] }}</h2>
                                        <h2 class="title">{{  $number[1] }}</h2>
                                    </div>
                                    Todas Las órdenes
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="{{route('user.orders', 'processing')}}" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </span>
                                <div class="cont">
                                    @php $number = number_format_short($orders->whereBetween('status', [1,2])->count()) @endphp
                                    <div class="dashboard-header">
                                        <h2 class="title">{{ $number[0] }}</h2>
                                        <h2 class="title">{{  $number[1] }}</h2>
                                    </div>
                                    Órdenes Por Procesar
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="{{route('user.orders', 'completed')}}" class="d-block">
                                <span class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </span>
                                <div class="cont">
                                    @php $number = number_format_short($orders->where('status', 3)->count()) @endphp
                                    <div class="dashboard-header">
                                        <h2 class="title">{{ $number[0] }}</h2>
                                        <h2 class="title">{{  $number[1] }}</h2>
                                    </div>
                                    Órdenes Completadas
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="{{route('user.orders', 'incomplete-payment')}}">
                                <span class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </span>
                                <div class="cont">
                                    @php $number = number_format_short($orders->where('payment_status', 0)->where('status', '!=', 4)->count()) @endphp
                                    <div class="dashboard-header">
                                        <h2 class="title">{{ $number[0] }}</h2>
                                        <h2 class="title">{{  $number[1] }}</h2>
                                    </div>
                                    Órdenes Incompletas
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="{{route('user.orders', 'canceled')}}">
                                <span class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </span>
                                <div class="cont">
                                    @php $number = number_format_short($orders->where('status', 4)->count()) @endphp
                                    <div class="dashboard-header">
                                        <h2 class="title">{{ $number[0] }}</h2>
                                        <h2 class="title">{{  $number[1] }}</h2>
                                    </div>
                                    Órdenes Canceladas
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="dashboard-item">
                            <a href="{{route('user.orders', 'pending')}}">
                                <span class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </span>
                                <div class="cont">
                                    @php $number = number_format_short($orders->where('status', 0)->count()) @endphp
                                    <div class="dashboard-header">
                                        <h2 class="title">{{ $number[0] }}</h2>
                                        <h2 class="title">{{  $number[1] }}</h2>
                                    </div>
                                    Órdenes Pendientes
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
