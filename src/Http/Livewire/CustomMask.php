<?php

namespace LiveControls\Masks\Http\Livewire;

class CustomMask extends MaskComponent
{
    public $mask;
    public $options;

    public function render()
    {
        return view('livecontrols-masks::livewire.custom-mask');
    }
}
