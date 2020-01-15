@extends('layouts.main')
@section('title', 'گواهی شغلی')
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
                    <h3 class="box-title"> ویرایش گواهی شغلی {{ $jobCertificate->id }} </h3>

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

                    <form action="{{ route('jobCertificates.update', ['jobCertificate' => $jobCertificate->id]) }}" method="post">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="job_certificate_id" value="{{ $jobCertificate->id }}">

                        {{--Personnel--}}
                        @component('components.select-option')
                            @slot('name', 'personnelId')
                            @slot('classWrapper', 'col-md-4')
                            @slot('id', 'personnelId')
                            @slot('label', 'پرسنل')
                            @foreach($personnelService->all() as $key => $personnel)
                                <option value="{{ $personnel->id }}"
                                    {{ ($personnel->id == $jobCertificate->personnel_id) ? "selected" : '' }}
                                > {{ $personnel->full_name }} </option>
                            @endforeach
                        @endcomponent

                        {{--ReceiveDate--}}
                        @component('components.input')
                            @slot('type', 'text')
                            @slot('name', 'receive_date')
                            @slot('id', 'receive_date')
                            @slot('label', 'تاریخ دریافت')
                            @slot('classWrapper', 'col-md-4')
                            @if(! is_null($jobCertificate->receive_date))
                                @slot('value', $dateConverter::toJalali($jobCertificate->receive_date))
                            @endif
                            @slot('required', 'required')
                        @endcomponent

                        <div class="clearfix"></div>

                        {{--Status--}}
                        {{--<div class="form-group col-md-4">--}}
                            {{--<label for="status">فعال</label>--}}
                            {{--<input type="checkbox" id="status" name="status"--}}
                                    {{--{{ ($jobCertificate->status == \App\JobCertificate::ENABLE)? 'checked' : null }}>--}}
                        {{--</div>--}}

                        <div class="clearfix"></div>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'update_jobCertificate')
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
        </script>
    @endpush

@endsection