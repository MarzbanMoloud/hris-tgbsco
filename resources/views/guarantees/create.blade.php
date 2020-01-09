@extends('layouts.main')
@section('title', 'تضامین')
@section('content')

    {{--InjectServices - start--}}
    @inject('personnelService', '\App\Services\Personnel\PersonnelService')
    {{--InjectServices - end--}}

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title"> ایجاد ضمانت </h3>

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

                    <form action="{{ route('guarantees.store') }}" method="post" id="create-guarantee-form">
                        @csrf

                        {{--Personnel--}}
                        @component('components.select-option')
                            @slot('name', 'personnelId')
                            @slot('id', 'personnelId')
                            @slot('label', 'پرسنل')
                            @slot('classWrapper', 'col-md-4')
                            @foreach($personnelService->all() as $key => $personnel)
                                <option value="{{ $personnel->id }}"> {{ $personnel->full_name }} </option>
                            @endforeach
                        @endcomponent

                        {{--Amount--}}
                        <div class="form-group col-md-4">
                            <label for="amount">مبلغ</label>
                            <input class="form-control"
                                   type="text"
                                   name="amount"
                                   id="amount"
                                   value=""
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
                            @slot('classWrapper', 'col-md-4')
                            @slot('required', 'required')
                        @endcomponent

                        {{--Status--}}
                        <div class="form-group col-md-4">
                            <label for="status">فعال</label>
                            <input type="checkbox" id="status" name="status">
                        </div>

                        <div class="clearfix"></div>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'create_guarantee')
                            @slot('id', 'create_guarantee')
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
            /*-------------------- DatePicker --------------------*/
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

            /*-------------------- PriceFormat --------------------*/
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

            /*-------------------- Check times of create loan for selected personnel --------------------*/
            $('#create_guarantee').on('click', function (e) {
                e.preventDefault();
                var selected_personnel = $('#personnelId').children("option:selected").val();

                $.ajax({
                    type: "get",
                    url: "/guarantees/times/" + selected_personnel,
                    success: function(count){
                        if (count >= 3) {
                            $('#frequently-facility-text').html(count);
                            $('#frequently-facility').modal("show");
                        } else {
                            $('#create-guarantee-form').submit();
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                $('#frequently-facility-btn').on('click', function () {
                    $('#create-guarantee-form').submit();
                });
            });
        </script>
    @endpush

@endsection