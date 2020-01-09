<div class="form-group {{ $classWrapper ?? '' }}">
    <input type="submit"
           name="{{ $name ?? '' }}"
           id="{{ $id ?? '' }}"
           class="btn btn-success {{ $class ?? '' }}"
           value="{{ $value }}"
           data-id="{{ $dataId ?? '' }}"
    >
</div>