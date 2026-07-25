<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
public int $cartCount;

    public function __construct()
    {
        $this->cartCount = auth()->check()
            ? (auth()->user()->cart?->items->sum('quantity') ?? 0)
            : 0;
    }

    public function render()
    {
        return view('components.header');
    }
}
