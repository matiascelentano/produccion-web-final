<?php

namespace App;

enum OrderStatus: string
{
    case Pendiente = 'pendiente';
    case Pagado = 'pagado';
    case Enviado = 'enviado';
    case Entregado = 'entregado';
    case Cancelado = 'cancelado';

    // Acá va la lógica de negocio de transiciones válidas
    public function puedeCambiarA(OrderStatus $nuevo): bool
    {
        return match($this) {
            self::Pendiente  => in_array($nuevo, [self::Pagado, self::Cancelado]),
            self::Pagado     => in_array($nuevo, [self::Enviado, self::Cancelado]),
            self::Enviado    => $nuevo === self::Entregado,
            self::Entregado, self::Cancelado => false, // estados finales
        };
    }
}