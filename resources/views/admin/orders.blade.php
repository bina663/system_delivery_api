@extends('template.admin')

@section('title', 'Pedidos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/orders.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <h2 class="mt-4 mb-4">Pedidos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex flex-wrap gap-4">
        @foreach($orders as $order)
            @php
                $statusMap = [
                    'pending'  => ['label' => 'Pendente',   'class' => 'text-light bg-warning'],
                    'preparing'  => ['label' => 'Preparando',   'class' => 'text-light bg-orange'],
                    'out_for_delivery' => ['label' => 'Saiu para entrega', 'class' => 'text-light bg-danger'],
                    'delivery' => ['label' => 'Entregue',   'class' => 'text-light bg-success'],
                    'cancelled' => ['label' => 'Cancelado',   'class' => 'text-light bg-secondary'],
                ];
                $statusInfo = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'text-dark bg-secondary'];

            @endphp

            <div class="card shadow-sm mb-4" style="width: 22rem;" id="order-{{ $order->id }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fa-regular fa-circle-check"></i>
                        Pedido #{{ $order->order_number ?? $order->id }}
                    </h5>
                    <span class="badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <strong>Cliente:</strong>
                        <span>{{ $order->customer->name ?? 'Cliente não encontrado' }}</span>
                    </div>
                <div class="mb-1">
                    <div class="d-flex align-items-center gap-2">
                        <strong>E-mail:</strong>
                        @if($order->customer->email ?? null)
                            <a class="link-contact" href="mailto:{{ $order->customer->email }}">{{ $order->customer->email }}</a>
                        @else
                            <span class="text-muted link-contact">Não informado</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-1">
                        <strong>Telefone:</strong>
                        @if($order->customer->telephone ?? null)
                            <a class="link-contact" href="https://wa.me/{{ $order->customer->telephone }}" target="_blank">{{ $order->customer->telephone }}</a>
                        @else
                            <span class="text-muted link-contact">Não informado</span>
                        @endif
                    </div>
                </div>
                @php
                    $addressParts = array_filter([
                        $order->customer->street ?? null,
                        $order->customer->number ?? null,
                    ]);
                    $addressLine = implode(', ', $addressParts);

                    $extraParts = array_filter([
                        $order->customer->neighborhood ?? null,
                        $order->customer->complement ?? null,
                    ]);
                @endphp

                @php
                    $mapsQuery = collect([
                        $order->customer->street ?? null,
                        $order->customer->number ?? null,
                        $order->customer->neighborhood ?? null,
                    ])->filter()->implode(', ');
                @endphp

                <div class="mb-3">
                    <div class="d-flex align-items-start  gap-2">
                        <strong class="text-nowrap">Endereço:</strong>
                        <span>
                            {{ $addressLine ?: 'Não informado' }}
                            @if($extraParts)
                                — {{ implode(', ', $extraParts) }}
                            @endif
                        </span>
                    </div>

                    @if($order->customer->point_reference ?? null)
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <strong class="text-nowrap">Referência:</strong>
                            <span class="text-muted small">{{ $order->customer->point_reference }}</span>
                        </div>
                    @endif
                    <div class="d-flex align-items-center gap-2 mt-1 ">
                        <strong class="text-nowrap">Frete:</strong><span class="text-success">R$ {{ number_format($order->delivery_fee ?? 0, 2, ',', '.') }}</span>
                    </div>
                    @if($mapsQuery)
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <i class="fa-regular fa-map"></i>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($mapsQuery) }}" target="_blank" rel="noopener noreferrer">
                                Abrir no Google Maps
                            </a>
                        </div>
                    @endif
                </div>

                    <hr class="my-2">

                    <h6 class="text-uppercase text-muted small mb-2">Itens do pedido</h6>

                    @forelse ($order->items as $item)
                        <div class="d-flex align-items-start gap-2 mb-2 pb-2 border-bottom">
                            @if ($item->product->image)
                                <img
                                    src="{{ $item->product->image ? asset('storage/products/' . $item->product->image) : '' }}"
                                    alt="{{ $item->product->name ?? 'Produto' }}"
                                    class="rounded"
                                    style="width: 48px; height: 48px; object-fit: cover;"
                                >
                            @endif
     

                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">{{ $item->product->name ?? 'Produto removido' }}</span>
                                    <span class="text-nowrap">{{ $item->quantity }}x R$ {{ number_format($item->unit_price, 2, ',', '.') }}</span>
                                </div>

                                @if (!empty($item->additionals))
                                    <div class="small text-muted mt-1">
                                        @foreach ($item->additionals as $additional)
                                            <div>+ {{ $additional['name'] ?? 'Adicional' }} ({{ $additional['quantity'] ?? 1 }}x)</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">Nenhum item neste pedido.</p>
                    @endforelse

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <strong>Total</strong>
                        <strong class="text-success fs-5">R$ {{ number_format( $order->total
                        , 2, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white">
                    @if($order->nextStatus())
                        <form action="{{ route('admin.orders.advance-status', $order->id) }}" method="POST" class="m-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                {{ $order->nextStatusLabel() }}
                            </button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-success" disabled>Pedido finalizado</button>
                    @endif

                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="m-0" onsubmit="return confirm('Cancelar este pedido?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Cancelar</button>
                    </form>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="m-0" onsubmit="return confirm('Remover este pedido?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection