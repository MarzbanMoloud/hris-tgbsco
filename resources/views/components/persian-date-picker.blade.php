<div class="form-group">

    @component('components.label')
        @slot('label', $label)
    @endcomponent

    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" id="tarikh" name="{{ $name }}" value="{{  $value ?? '' }}" class="form-control pull-right">
        <input type="hidden" id="tarikhAlt"  class="form-control pull-right">
    </div>

</div>