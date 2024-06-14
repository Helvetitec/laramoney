<?php

namespace LiveControls\Masks\Http\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class MaskComponent extends Component
{
    public $maskId = 'value';
    public $maskName = 'value';

    public $unmaskedId;
    public $unmaskedName;

    public $class = 'input input-bordered w-full';

    public $required = false;

    public $value;
    public $maskedValue;

    public $updateCallName;


    public function mount(){
        if(is_null($this->value)){
            $this->dispatch('update-mask-value', value: 0)->self();
        }else{
            $this->dispatch('update-mask-value', value: $this->value)->self();
        }
        if(is_null($this->updateCallName)){
            $this->updateCallName = $this->maskId.'-updated';
        }
    }

    public function updatedMaskedValue($value)
    {
        $this->dispatch($this->maskId.'-valueUpdated', value: $value);
    }

    public function updatedValue($value)
    {
        $this->dispatch($this->maskId.'-unmaskedUpdate', value: $value);
    }

    #[On('update-mask-value-{maskId}')]
    public function updateMaskFromOutside($value){
        $this->value = $value;
        $this->dispatch('update-mask-value', value: $this->value)->self();
    }
}
