<div>
    <input
        id="{{ $maskId }}"
        name="{{ $maskName }}"
        type="text"
        class="{{ $class }}"
        @if($required) required @endif
    />

    @if(!is_null($unmaskedId))
        <input
            id="{{ $unmaskedId }}"
            name="{{ $unmaskedId }}"
            type="text"
            style="display:none;"
            wire:model.live='value'
            value="{{ $value }}"
        />
    @endif

    @script
    <script type="text/javascript">
        window.{{ $maskId }}mask = IMask(
            document.getElementById('{{ $maskId }}'),
            {
                mask: '00.000.000/0000-00'
            }
        );

        $wire.on('update-mask-value', (event) => {
            window.{{ $maskId }}mask.unmaskedValue = "" + event.value;
        });

        window.{{ $maskId }}mask.on('accept', () => {
            $wire.value = Number(window.{{ $maskId }}mask.unmaskedValue);
            $wire.dispatch('{{ $updateCallName }}', { value: $wire.value });
        });
    </script>
    @endscript
</div>
