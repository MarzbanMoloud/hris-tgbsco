@extends('layouts.main')
@section('title', 'تضامین')
@section('content')

    {{--InjectServices - start--}}
    @inject('dateConverter', '\App\Services\DateConverter\DateConverter')
    @inject('personnelService', '\App\Services\Personnel\PersonnelService')
    {{--InjectServices - end--}}

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title"> ویرایش ضمانت {{ $guarantee->id }} </h3>

                    <hr>
                    {{--List--}}
                    <div class="form-group">
                        <a href="{{ route('guarantees.index') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-list"></i>
                            لیست تضامین
                        </a>
                    </div>
                    <hr>

                    <!-- tools box -->
                    <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <div class="box-body">

                    @include('common.validation')

                    <form action="{{ route('guarantees.update', ['guarantee' => $guarantee->id]) }}" method="post">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="guarantee_id" value="{{ $guarantee->id }}">

                        {{--Personnel--}}
                        @component('components.select-option')
                            @slot('name', 'personnelId')
                            @slot('classWrapper', 'col-md-4')
                            @slot('id', 'personnelId')
                            @slot('label', 'پرسنل')
                            @slot('requiredSign', "*")
                            @foreach($personnelService->all() as $key => $personnel)
                                @if($personnel->id == $guarantee->personnel_id)
                                <option value="{{ $personnel->id }}" selected> {{ $personnel->full_name }} </option>
                                @endif
                            @endforeach
                        @endcomponent

                        {{--Amount--}}
                        <div class="form-group col-md-4">
                            <label for="amount">مبلغ</label>
                            <span style="color: red">*</span>
                            <input class="form-control"
                                   type="text"
                                   name="amount"
                                   id="amount"
                                   value="{{ $guarantee->amount }}"
                                   data-type="currency"
                                   required
                                   placeholder="1,000,000 ریال">
                        </div>

                        {{--ReceiveDate--}}
                        @component('components.input')
                            @slot('type', 'text')
                            @slot('name', 'receive_date')
                            @slot('id', 'receive_date')
                            @slot('label', 'تاریخ دریافت')
                            @slot('requiredSign', "*")
                            @slot('classWrapper', 'col-md-4')
                            @if(! is_null($guarantee->receive_date))
                                @slot('value', $dateConverter::toJalali($guarantee->receive_date))
                            @endif
                            @slot('required', 'required')
                        @endcomponent

                        {{--DeliveryDate--}}
                        @component('components.input')
                            @slot('type', 'text')
                            @slot('name', 'delivery_date')
                            @slot('id', 'delivery_date')
                            @slot('label', 'تاریخ تحویل')
                            @if(! is_null($guarantee->delivery_date))
                                @slot('value', $dateConverter::toJalali($guarantee->delivery_date))
                            @endif
                            @slot('classWrapper', 'col-md-4')
                        @endcomponent

                        {{--UseCase--}}
                        @component('components.select-option')
                            @slot('name', 'use_case')
                            @slot('id', 'use_case')
                            @slot('label', 'مورد استفاده ضمانت')
                            @slot('classWrapper', 'col-md-4')
                            <option value=""></option>
                            @foreach(\App\Guarantee::USE_CASES as $key => $useCase)
                                <option value="{{ $key }}"
                                        {{ ($guarantee->use_case == $key) ? "selected" : "" }}
                                > {{ $useCase }} </option>
                            @endforeach
                        @endcomponent

                        {{--Type--}}
                        @component('components.select-option')
                            @slot('name', 'type')
                            @slot('id', 'type')
                            @slot('label', 'نوع ضمانت')
                            @slot('classWrapper', 'col-md-4')
                            <option value=""></option>
                            @foreach(\App\Guarantee::TYPES as $key => $type)
                                <option value="{{ $key }}"
                                        {{ ($guarantee->type == $key) ? "selected" : "" }}
                                > {{ $type }} </option>
                            @endforeach
                        @endcomponent

                        {{--Status--}}
                        {{--<div class="form-group col-md-4">--}}
                            {{--<label for="status">فعال</label>--}}
                            {{--<input type="checkbox" id="status" name="status"--}}
                                    {{--{{ ($guarantee->status == \App\Guarantee::ENABLE)? 'checked' : null }}>--}}
                        {{--</div>--}}

                        <div class="clearfix"></div>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'update_guarantee')
                            @slot('classWrapper', 'col-md-4')
                            @slot('value', 'ثبت')
                        @endcomponent

                    </form>

                </div>
            </div>
        </section>
    </div>

    @push('js')
        <script>
            var customOptions = {
                placeholder: "روز / ماه / سال"
                , twodigit: false
                , closeAfterSelect: false
                , nextButtonIcon: "fa fa-arrow-circle-right"
                , previousButtonIcon: "fa fa-arrow-circle-left"
                , buttonsColor: "blue"
                , forceFarsiDigits: true
                , markToday: true
                , markHolidays: true
                , highlightSelectedDay: true
                , sync: true
                , gotoToday: true
            };

            kamaDatepicker('receive_date', customOptions);
            kamaDatepicker('delivery_date', customOptions);

            formatCurrency($('#amount'));

            $('#amount').on({
                keyup: function() {
                    formatCurrency($(this));
                },
                blur: function() {
                    formatCurrency($(this), "blur");
                }
            });
            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
            function formatCurrency(input, blur) {
                // appends $ to value, validates decimal side
                // and puts cursor back in right position.

                // get input value
                var input_val = input.val();

                // don't validate empty input
                if (input_val === "") { return; }

                // original length
                var original_len = input_val.length;

                // initial caret position
                var caret_pos = input.prop("selectionStart");

                // check for decimal
                if (input_val.indexOf(".") >= 0) {

                    // get position of first decimal
                    // this prevents multiple decimals from
                    // being entered
                    var decimal_pos = input_val.indexOf(".");

                    // split number by decimal point
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    // add commas to left side of number
                    left_side = formatNumber(left_side);

                    // validate right side
                    right_side = formatNumber(right_side);

                    // On blur make sure 2 numbers after decimal
                    // if (blur === "blur") {
                    //     right_side += "00";
                    // }

                    // Limit decimal to only 2 digits
                    right_side = right_side.substring(0, 2);

                    // join number by .
                    input_val =  left_side + "." + right_side + " ریال ";

                } else {
                    // no decimal entered
                    // add commas to number
                    // remove all non-digits
                    input_val = formatNumber(input_val);
                    input_val = input_val + " ریال ";

                    // final formatting
                    // if (blur === "blur") {
                    //     input_val += ".00";
                    // }
                }

                // send updated string to input
                input.val(input_val);

                // put caret back in the right position
                var updated_len = input_val.length;
                caret_pos = updated_len - original_len + caret_pos;
                input[0].setSelectionRange(caret_pos, caret_pos);
            }
        </script>
    @endpush

@endsection