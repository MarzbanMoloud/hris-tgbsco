@extends('layouts.main')
@section('title', 'پرسنل')
@section('content')

    {{--InjectServices - start--}}
    @inject('organizationalUnitService', '\App\Services\OrganizationalUnit\OrganizationalUnitService')
    @inject('jobService', '\App\Services\Job\JobService')
    @inject('projectService', '\App\Services\Project\ProjectService')
    @inject('centralCostService', '\App\Services\CentralCost\CentralCostService')
    {{--InjectServices - end--}}

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-plus"></i>
                    <h3 class="box-title"> ایجاد پرسنل </h3>

                    <hr>
                    {{--List--}}
                    <div class="form-group">
                        <a href="{{ route('personnels.index') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-list"></i>
                            لیست پرسنل
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

                    <form method="POST" enctype="multipart/form-data" id="upload_image_form">
                        <div class="row">
                            {{--Preview--}}
                            <div class="col-md-12 mb-2">

                                <img id="image_preview_container" src="
                                    @if(old('image_id') != null)
                                        {{ \App\Image::find(old('image_id'))->src }}
                                    @else
                                        {{ asset('images/no-image-found.jpg') }}
                                    @endif"
                                alt="preview image" style="width: 100px; height: 100px; border-radius: 50%">
                            </div>
                            {{--File input--}}
                            <div class="col-md-6 ml-5">
                                <div class="form-group">
                                    <input type="file" name="image" id="image">
                                    <button type="submit" id="upload-btn" class="btn btn-primary btn-xs">آپلود</button>
                                </div>
                                {{--Message upload--}}
                                <div id="message"></div>

                            </div>
                        </div>
                    </form>

                    <form action="{{ route('personnels.store') }}" method="post">
                        @csrf

                        <input type="hidden" id="image_id" name="image_id"  value="{{ old('image_id') }}">

                        <div class="card text-white bg-info m-5">
                            <div class="card-header" style="padding: 5px; margin-bottom: 5px">
                                اطلاعات پایه
                            </div>
                            <div class="card-body">
                                <div class="col-md-3">
                                    {{--FirstName--}}
                                    @component('components.input')
                                        @slot('name', 'first_name')
                                        @slot('type', 'text')
                                        @slot('id', 'first_name')
                                        @slot('label', 'نام*')
                                        @slot('required', 'required')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--LastName--}}
                                    @component('components.input')
                                        @slot('name', 'last_name')
                                        @slot('type', 'text')
                                        @slot('id', 'last_name')
                                        @slot('label', 'نام خانوادگی*')
                                        @slot('required', 'required')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--FatherName--}}
                                    @component('components.input')
                                        @slot('name', 'father_name')
                                        @slot('type', 'text')
                                        @slot('id', 'father_name')
                                        @slot('label', 'نام پدر*')
                                        @slot('required', 'required')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--CertificateId--}}
                                    @component('components.input')
                                        @slot('name', 'certificate_id')
                                        @slot('type', 'number')
                                        @slot('id', 'certificate_id')
                                        @slot('label', 'شماره شناسنامه')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--NationalCode--}}
                                    @component('components.input')
                                        @slot('name', 'national_code')
                                        @slot('type', 'number')
                                        @slot('id', 'national_code')
                                        @slot('label', 'کد ملی')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--BirthDate--}}
                                    @component('components.input')
                                        @slot('name', 'birth_date')
                                        @slot('type', 'text')
                                        @slot('id', 'birth_date')
                                        @slot('label', 'تاریخ تولد')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--CertificateSerial--}}
                                    @component('components.input')
                                    @slot('name', 'certificate_serial')
                                    @slot('type', 'text')
                                    @slot('id', 'certificate_serial')
                                    @slot('label', 'سریال شناسنامه')
                                @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--IssuanceLocation--}}
                                    @component('components.input')
                                        @slot('name', 'issuance_location')
                                        @slot('type', 'text')
                                        @slot('id', 'issuance_location')
                                        @slot('label', 'محل صدور')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--Gender--}}
                                    @component('components.select-option')
                                        @slot('name', 'gender')
                                        @slot('id', 'gender')
                                        @slot('label', 'جنسیت')
                                        <option value=""></option>
                                        @foreach(\App\Personnel::GENDER as $key => $status)
                                            <option value="{{ $key }}"
                                                    {{ ((old('gender') != null) && (old('gender') == $key)) ? "selected" : '' }}
                                            > {{ $status }} </option>
                                        @endforeach
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--MaritalStatus--}}
                                    @component('components.select-option')
                                        @slot('name', 'marital_status')
                                        @slot('id', 'marital_status')
                                        @slot('label', 'وضعیت تاهل')
                                        <option value=""></option>
                                        @foreach(\App\Personnel::MARITAL_STATUS as $key => $status)
                                            <option value="{{ $key }}"
                                            {{ ((old('marital_status') != null) && (old('marital_status') == $key)) ? "selected" : '' }}
                                            > {{ $status }} </option>
                                        @endforeach
                                    @endcomponent
                                </div>
                                <div class="col-md-3 hide" id="childrenCountWrapper">
                                    {{--ChildrenCount--}}
                                    @component('components.input')
                                    @slot('name', 'children_count')
                                    @slot('type', 'number')
                                    @slot('id', 'children_count')
                                    @slot('label', 'تعداد فرزندان')
                                @endcomponent
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="card text-white bg-info m-5">
                            <div class="card-header" style="padding: 5px; margin-bottom: 5px">
                                اطلاعات بیمه و وظیفه
                            </div>
                            <div class="card-body">
                                <div class="col-md-3">
                                    {{--IssuanceId--}}
                                    @component('components.input')
                                        @slot('name', 'issuance_id')
                                        @slot('type', 'number')
                                        @slot('id', 'issuance_id')
                                        @slot('label', 'شماره بیمه')
                                    @endcomponent
                                </div>
                                <div class="col-md-3 hide" id="militaryStatusWrapper">
                                    {{--MilitaryStatus--}}
                                    @component('components.select-option')
                                    @slot('name', 'military_status')
                                    @slot('id', 'military_status')
                                    @slot('label', 'وضعیت نظام وظیفه')
                                        <option value=""></option>
                                    @foreach(\App\Personnel::MILITARY_STATUS as $key => $status)
                                        <option value="{{ $key }}"
                                                {{ ((old('military_status') != null) && (old('military_status') == $key)) ? "selected" : "" }}
                                        > {{ $status }} </option>
                                    @endforeach
                                @endcomponent
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="card text-white bg-info m-5">
                            <div class="card-header" style="padding: 5px; margin-bottom: 5px">
                                اطلاعات تحصیلی
                            </div>
                            <div class="card-body">
                                <div class="col-md-3">
                                    {{--EducationDegree--}}
                                    @component('components.select-option')
                                        @slot('name', 'education_degree')
                                        @slot('id', 'education_degree')
                                        @slot('label', 'مدرک تحصیلی')
                                        <option value=""></option>
                                        @foreach(\App\Personnel::EDUCATION_DEGREE as $key => $status)
                                            <option value="{{ $key }}"
                                                    {{ ((old('education_degree') != null) && (old('education_degree') == $key)) ? "selected" : "" }}
                                            > {{ $status }} </option>
                                        @endforeach
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--Major--}}
                                    @component('components.input')
                                        @slot('type', 'text')
                                        @slot('name', 'major')
                                        @slot('id', 'major')
                                        @slot('label', 'رشته تحصیلی')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--EducationLocation--}}
                                    @component('components.input')
                                        @slot('type', 'text')
                                        @slot('name', 'education_location')
                                        @slot('id', 'education_location')
                                        @slot('label', 'محل تحصیل')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                {{--UniversityType--}}
                                @component('components.select-option')
                                    @slot('name', 'university_type')
                                    @slot('id', 'university_type')
                                    @slot('label', 'نوع دانشگاه')
                                    <option value=""></option>
                                    @foreach(\App\Personnel::UNIVERSITY_TYPES as $key => $status)
                                        <option value="{{ $key }}"
                                                {{ ((old('education_degree') != null) && (old('university_type') == $key)) ? "selected" : "" }}
                                        > {{ $status }} </option>
                                    @endforeach
                                @endcomponent
                            </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="card text-white bg-info m-5">
                            <div class="card-header" style="padding: 5px; margin-bottom: 5px">
                                اطلاعات پرسنلی
                            </div>
                            <div class="card-body">
                                <div class="col-md-3">
                                    {{--PersonnelCode--}}
                                    @component('components.input')
                                        @slot('name', 'personnel_code')
                                        @slot('type', 'number')
                                        @slot('id', 'personnel_code')
                                        @slot('label', 'کد پرسنلی*')
                                        @slot('required', 'required')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--HireDate--}}
                                    @component('components.input')
                                        @slot('type', 'text')
                                        @slot('name', 'hire_date')
                                        @slot('id', 'hire_date')
                                        @slot('label', 'تاریخ استخدام')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--EndDate--}}
                                    @component('components.input')
                                        @slot('type', 'text')
                                        @slot('name', 'end_date')
                                        @slot('id', 'end_date')
                                        @slot('label', 'تاریخ اتمام همکاری')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--OrganizationalUnit--}}
                                    @component('components.select-option')
                                        @slot('name', 'organizational_unit_id')
                                        @slot('id', 'organizational_unit_id')
                                        @slot('label', 'واحد سازمانی')
                                        <option value="" selected></option>
                                        @foreach($organizationalUnitService->all() as $key => $organizationalUnit)
                                            <option value="{{ $organizationalUnit->id }}"
                                                    {{ ((old('organizational_unit_id') != null) && (old('organizational_unit_id') == $organizationalUnit->id)) ? "selected" : "" }}
                                            > {{ $organizationalUnit->title }} </option>
                                        @endforeach
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--Job--}}
                                    @component('components.select-option')
                                        @slot('name', 'job_id')
                                        @slot('id', 'job_id')
                                        @slot('label', 'شغل')
                                        <option value=""></option>
                                        @foreach($jobService->all() as $key => $job)
                                            <option value="{{ $job->id }}"
                                                    {{ ((old('job_id') != null) && (old('job_id') == $job->id)) ? "selected" : "" }}
                                            > {{ $job->title }} </option>
                                        @endforeach
                                    @endcomponent
                                </div>
                                <div class="col-md-6">
                                    {{--Projects--}}
                                    @component('components.select2-option')
                                        @slot('name', 'projects[]')
                                        @slot('id', 'projects')
                                        @slot('class', 'js-example-basic-multiple')
                                        @slot('label', 'پروژه')
                                        @foreach($projectService->all() as $key => $project)
                                            <option value="{{ $project->id }}"
                                                    {{ ((old('projects') != null) && (old('projects') == $project->id)) ? "selected" : "" }}
                                            > {{ $project->title }} </option>
                                        @endforeach
                                    @endcomponent
                                </div>
                                {{--<div class="col-md-3">--}}
                                    {{--CentralCost--}}
                                    {{--@component('components.select-option')--}}
                                        {{--@slot('name', 'central_cost_id')--}}
                                        {{--@slot('id', 'central_cost_id')--}}
                                        {{--@slot('label', 'مرکز هزینه')--}}
                                        {{--<option value=""></option>--}}
                                        {{--@foreach($centralCostService->all() as $key => $centralCost)--}}
                                            {{--<option value="{{ $centralCost->id }}"--}}
                                                    {{--{{ ((old('central_cost_id') != null) && (old('central_cost_id') == $centralCost->id)) ? "selected" : "" }}--}}
                                            {{--> {{ $centralCost->title }} </option>--}}
                                        {{--@endforeach--}}
                                    {{--@endcomponent--}}
                                {{--</div>--}}
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="card text-white bg-info m-5">
                            <div class="card-header" style="padding: 5px; margin-bottom: 5px">
                                اطلاعات ارتباطی
                            </div>
                            <div class="card-body">
                                <div class="col-md-3">
                                    {{--MobileNumber--}}
                                    @component('components.input')
                                        @slot('name', 'mobile_number')
                                        @slot('type', 'number')
                                        @slot('id', 'mobile_number')
                                        @slot('label', 'شماره موبایل')
                                    @endcomponent
                                </div>
                                <div class="col-md-3">
                                    {{--PhoneNumber--}}
                                    @component('components.input')
                                        @slot('name', 'phone_number')
                                        @slot('type', 'number')
                                        @slot('id', 'phone_number')
                                        @slot('label', 'شماره تلفن ثابت')
                                    @endcomponent
                                </div>
                                <div class="col-md-6">
                                {{--Address--}}
                                @component('components.textarea')
                                    @slot('name', 'address')
                                    @slot('id', 'address')
                                    @slot('rows', 1)
                                    @slot('label', 'آدرس محل سکونت')
                                @endcomponent
                            </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <hr>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'create_personnel')
                            @slot('value', 'ثبت نهایی')
                        @endcomponent

                    </form>

                </div>
            </div>
        </section>
    </div>

    @push('js')

        <script>
            $(document).ready(function() {
                $('#projects').select2({
                    dir: "rtl",
                    dropdownAutoWidth: true,
                });

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

                kamaDatepicker('hire_date', customOptions);
                kamaDatepicker('end_date', customOptions);
                kamaDatepicker('birth_date', customOptions);

                /*------------------ marital_status ------------------*/
                var selectedStatus = $('#marital_status').children("option:selected").val();
                if (selectedStatus == 1){
                    $('#childrenCountWrapper').removeClass('hide');
                }
                if (selectedStatus == ""){
                    $('#childrenCountWrapper').addClass('hide');
                }
                $('#marital_status').change(function () {
                    var selectedStatus = $('#marital_status').children("option:selected").val();
                    if (selectedStatus == 1){
                        $('#childrenCountWrapper').removeClass('hide');
                    }
                    if (selectedStatus == 0 || selectedStatus == ""){
                        $('#childrenCountWrapper').addClass('hide');
                    }
                });

                /*------------------ Gender ------------------*/
                var selectedGender = $('#gender').children("option:selected").val();
                if (selectedGender == 1){
                    $('#militaryStatusWrapper').removeClass('hide');
                }
                if (selectedGender == ""){
                    $('#militaryStatusWrapper').addClass('hide');
                }
                $('#gender').change(function () {
                    var selectedGender = $('#gender').children("option:selected").val();
                    if (selectedGender == 1){
                        $('#militaryStatusWrapper').removeClass('hide');
                    }
                    if (selectedGender == 0 || selectedGender == ""){
                        $('#militaryStatusWrapper').addClass('hide');
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#image').change(function(){

                    let reader = new FileReader();
                    reader.onload = (e) => {
                        $('#image_preview_container').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);

                });

                $('#upload_image_form').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('uploadFile')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $('#message').css('display', 'block');
                            $('#message').html(data.message);
                            $('#message').css('color', data.color);
                            $('#image_id').val(data.image_id);
                            $('#image_preview_container').src(data.uploaded_image);
                            this.reset();
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });

            });
        </script>
    @endpush

@endsection