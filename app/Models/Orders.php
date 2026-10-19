<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;
class Orders extends Model
{
    public const STATUS_PENDING     = 'pending';
    public const STATUS_PREPARING   = 'preparing';
    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    public const STATUS_DELIVERED   = 'delivery';
    public const STATUS_CANCELLED   = 'cancelled';

    // Define a ordem do fluxo
    public const STATUS_FLOW = [
        self::STATUS_PENDING,
        self::STATUS_PREPARING,
        self::STATUS_OUT_FOR_DELIVERY,
        self::STATUS_DELIVERED,
        Self::STATUS_CANCELLED,
    ];
    protected $fillable = [
        'customer_id',
        'total',
        'status',
        '_status'
    ];
    

        /**
     * Retorna o próximo status no fluxo, ou null se já for o último.
     */
    public function nextStatus(): ?string
    {
        $currentIndex = array_search($this->status, self::STATUS_FLOW);

        if ($currentIndex === false || $currentIndex === count(self::STATUS_FLOW) - 1) {
            return null; // já é o último status, ou status desconhecido
        }

        return self::STATUS_FLOW[$currentIndex + 1];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING          => 'Pendente',
            self::STATUS_PREPARING        => 'Preparando',
            self::STATUS_OUT_FOR_DELIVERY => 'Saiu para entrega',
            self::STATUS_DELIVERED        => 'Entregue',
            self::STATUS_CANCELLED        => 'Cancelado',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING          => 'text-dark bg-light border',
            self::STATUS_PREPARING        => 'text-light bg-warning',
            self::STATUS_OUT_FOR_DELIVERY => 'text-light bg-info',
            self::STATUS_DELIVERED        => 'text-light bg-success',
            self::STATUS_CANCELLED        => 'text-light bg-danger',
            default => 'text-dark bg-secondary',
        };
    }

    public function nextStatusLabel(): ?string
    {
        return match ($this->nextStatus()) {
            self::STATUS_PREPARING        => 'Iniciar preparo',
            self::STATUS_OUT_FOR_DELIVERY => 'Saiu para entrega',
            self::STATUS_DELIVERED        => 'Marcar como entregue',
            self::STATUS_CANCELLED        => 'Marcar como cancelado',
            default => null,
        };
    }
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
    
    public function items()
    {
        return $this->hasMany(OrdersItem::class, 'order_id');
    }
}
