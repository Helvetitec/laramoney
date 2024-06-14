<?php

namespace LiveControls\Masks\Http\Livewire;

class CurrencyMask extends MaskComponent
{
    public string $currencyString = '$';
    
    public function render()
    {
        return view('livecontrols-masks::livewire.currency-mask');
    }
}
