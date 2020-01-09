<div class="form-group {{ $classWrapper ?? ''}}">

    @component('components.label')
        @slot('label', $label)
        @slot('id', $id ?? '')
    @endcomponent

    <input type="{{ $type }}"
           class="{{ ($type != 'checkbox')? 'form-control' : '' }} {{ $class ?? '' }}"
           id="{{ $id ?? '' }}"
           name="{{ $name }}"
           value="{{ $value ?? old($name) }}"
           data-id="{{ $data_id ?? '' }}"
           placeholder="{{ $placeHolder ?? '' }}"
           {{ $readOnly ?? '' }}
           {{ $checked ?? '' }}
           {{ $disabled ?? '' }}
           {{ $required ?? '' }}
    />

</div>