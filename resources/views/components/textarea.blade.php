<div class="form-group {{ $classWrapper ?? ''}}">

    @component('components.label')
        @slot('label', $label)
        @slot('id', $id)
    @endcomponent

    <textarea name="{{ $name }}"
              id="{{ $id ?? '' }}"
              class="form-control {{ $class ?? '' }}"
              cols="{{ $cols ?? 30 }}"
              rows="{{ $rows ?? 10 }}"
    >
        {{ $value ?? old($name) }}
    </textarea>

</div>