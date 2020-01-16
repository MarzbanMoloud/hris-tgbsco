<div class="form-group {{ $classWrapper ?? '' }}" style="{{ $style ?? '' }}">
    <input type="submit"
           name="{{ $name ?? '' }}"
           id="{{ $id ?? '' }}"
           class="btn btn-success {{ $class ?? '' }}"
           value="{{ $value }}"
           data-id="{{ $dataId ?? '' }}"
    >
</div>