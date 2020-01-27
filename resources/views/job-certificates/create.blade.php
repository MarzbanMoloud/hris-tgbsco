@extends('layouts.main')
@section('title', 'گواهی شغلی')
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
                    <h3 class="box-title"> ایجاد گواهی شغلی </h3>

                    <hr>
                    {{--List--}}
                    <div class="form-group">
                        <a href="{{ route('jobCertificates.index') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-list"></i>
                             لیست گواهی های شغلی
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

                    <form action="{{ route('jobCertificates.store') }}" method="post" id="create-jobCertificates-form">
                        @csrf

                        {{--PersonnelStatus--}}
                        @component('components.select-option')
                            @slot('name', 'personnel_status')
                            @slot('id', 'personnel_status')
                            @slot('label', 'وضعیت پرسنل')
                            @slot('classWrapper', 'col-md-4')
                            @foreach(\App\Personnel::STATUSES as $key => $status)
                                @if($key != \App\Personnel::DELETED)
                                    <option value="{{ $key }}"> {{ $status }} </option>
                                @endif
                            @endforeach
                        @endcomponent

                        {{--Personnel--}}
                        @component('components.select-option')
                            @slot('name', 'personnelId')
                            @slot('id', 'personnelId')
                            @slot('label', 'پرسنل')
                            @slot('requiredSign', "*")
                            @slot('classWrapper', 'col-md-4')
                            @foreach($personnelService->all() as $key => $personnel)
                                <option value="{{ $personnel->id }}"> {{ $personnel->full_name }} </option>
                            @endforeach
                        @endcomponent

                        {{--ReceiveDate--}}
                        @component('components.input')
                            @slot('type', 'text')
                            @slot('name', 'receive_date')
                            @slot('id', 'receive_date')
                            @slot('label', 'تاریخ دریافت')
                            @slot('requiredSign', "*")
                            @slot('classWrapper', 'col-md-4')
                            @slot('required', 'required')
                        @endcomponent

                        <div class="clearfix"></div>

                        {{--Status--}}
                        {{--<div class="form-group col-md-4">--}}
                            {{--<label for="status">فعال</label>--}}
                            {{--<input type="checkbox" id="status" name="status">--}}
                        {{--</div>--}}

                        <div class="clearfix"></div>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'create_jobCertificates')
                            @slot('id', 'create_jobCertificates')
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

            /*-------------------- Check times of create jobCertificates for selected personnel --------------------*/
            $('#create_jobCertificates').on('click', function (e) {
                e.preventDefault();
                var selected_personnel = $('#personnelId').children("option:selected").val();

                $.ajax({
                    type: "get",
                    url: "{{ URL::to('jobCertificates/times') }}"+ '/' + selected_personnel,
                    success: function(count){
                        if (count >= 3) {
                            $('#frequently-facility-text').html(count);
                            $('#frequently-facility').modal("show");
                        } else {
                            $('#create-jobCertificates-form').submit();
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

                $('#frequently-facility-btn').on('click', function () {
                    $('#create-jobCertificates-form').submit();
                });
            });

            /*-------------------- Load personnel list based on selected personnel status --------------------*/
            $("#personnel_status").change(function() {
                $('#personnelId').empty();

                var selected_status = $( this ).children("option:selected").val();

                $.ajax({
                    type: "get",
                    url: "{{ URL::to('personnels/list') }}"+ '/' + selected_status,
                    success: function(personnels){
                        $.each( personnels, function( key, personnel ) {
                            $('#personnelId').append('<option value="'+ personnel.id +'">' + personnel.full_name + '</option>');
                        });
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
        </script>
    @endpush

@endsection