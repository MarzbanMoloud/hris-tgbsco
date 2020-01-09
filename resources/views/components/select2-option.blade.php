<div class="form-group">

    @component('components.label')
        @slot('label', $label)
    @endcomponent

    <select class="form-control {{ $class ?? '' }}"
            name="{{ $name }}"
            id="{{ $id ?? '' }}" multiple="multiple"
            style="width: 100%"
    >

        {{ $slot }}

    </select>
</div>