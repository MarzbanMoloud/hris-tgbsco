<div class="form-group {{ $classWrapper ?? '' }}">

    @component('components.label')
        @slot('label', $label ?? '')
        @slot('requiredSign', $requiredSign ?? '')
    @endcomponent

    <select class="form-control {{ $class ?? '' }}"
            name="{{ $name }}"
            id="{{ $id ?? '' }}"
    >

        {{ $slot }}

    </select>
</div>