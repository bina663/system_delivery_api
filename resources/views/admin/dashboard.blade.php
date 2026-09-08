@extends('template.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Total de Pedidos -->
        <div class="col-md-3 ">
            <div class="card p-3 text-center bg-warning text-light">
                <h5>Pedidos Pendentes</h5>
                <h2>{{ $ordersPending }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center text-light bg-orange">
                <h5>Pedidos Preparando</h5>
                <h2>{{ $ordersPreparing }}</h2>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="card p-3 text-center bg-danger text-light">
                <h5>Pedidos saindo para entrega</h5>
                <h2>{{ $ordersOutDelivery }}</h2>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="card p-3 text-center bg-success text-light">
                <h5>Pedidos finalizados</h5>
                <h2>{{ $ordersDelivery }}</h2>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="card p-3 text-center bg-secondary text-light">
                <h5>Pedidos Cancelados</h5>
                <h2>{{ $ordersCancel }}</h2>
            </div>
        </div>


        <!-- Total Vendas -->
        <div class="col-md-3">
            <div class="card p-3 text-center bg-primary text-light">
                <h5>Vendas</h5>
                <h2>R$ {{ number_format($ordersValueTotal, 2, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection