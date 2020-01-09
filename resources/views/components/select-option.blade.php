<div class="form-group {{ $classWrapper ?? '' }}">

    @component('components.label')
        @slot('label', $label)
    @endcomponent

    <select class="form-control {{ $class ?? '' }}"
            name="{{ $name }}"
            id="{{ $id ?? '' }}"
    >

        {{ $slot }}

    </select>
</div>