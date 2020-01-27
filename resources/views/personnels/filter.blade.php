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
                    <i class="fa fa-list"></i>
                    <h3 class="box-title"> لیست پرسنل </h3>

                    <hr>
                    @role([config('roleconst.admin'), config('roleconst.normal')])
                    {{--ImportExportExcelAndCreate--}}
                    <div class="form-group">
                        <a href="{{ route('personnels.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد پرسنل جدید
                        </a>

                        <a href="#" class="btn btn-info btn-xs" id="import_personnel_xls">
                            <i class="fa fa-file-excel-o"></i>
                            وارد کردن اکسل
                        </a>
                    </div>
                    @endrole
                    <hr>

                    <form action="{{ route('personnels.filter') }}" method="get" style="background-color: #ddd; border-radius: 5px; padding: 10px">
                        {{--@csrf--}}

                        <button type="submit" name="export-filter" class="btn btn-primary btn-xs">
                            <i class="fa fa-file-excel-o"></i>
                            خروجی اکسل
                        </button>

                        <div class="row">
                            <div class="form-group col-md-6">
                                @component('components.select2-option')
                                    @slot('name', 'projects[]')
                                    @slot('id', 'projects')
                                    @slot('class', 'js-example-basic-multiple')
                                    @slot('label', 'پروژه:')
                                    @foreach($projectService->all() as $key => $project)
                                        <option value="{{ $project->id }}"
                                            @if(isset(request()->projects))
                                                @foreach(request()->projects as $item)
                                                    {{ ($item == $project->id) ? "selected" : '' }}
                                                @endforeach
                                            @endif
                                        > {{ $project->title }} </option>
                                    @endforeach
                                @endcomponent
                            </div>
                            <div class="form-group col-md-3">
                                @component('components.select-option')
                                    @slot('name', 'organizationalUnit')
                                    @slot('id', 'organizationalUnit')
                                    @slot('label', 'واحد سازمانی:')
                                    <option value=""></option>
                                    @foreach($organizationalUnitService->all() as $key => $organizationalUnit)
                                        <option value="{{ $organizationalUnit->id }}"
                                            {{ ( (isset(request()->organizationalUnit)) && ($organizationalUnit->id == request()->organizationalUnit) ) ? "selected" : '' }}
                                        > {{ $organizationalUnit->title }} </option>
                                    @endforeach
                                @endcomponent
                            </div>
                            <div class="form-group col-md-3">
                                @component('components.select-option')
                                    @slot('name', 'personnelStatus')
                                    @slot('id', 'personnelStatus')
                                    @slot('label', 'وضعیت پرسنل:')
                                    <option value=""></option>
                                    <option value="1"
                                            {{ ( (isset(request()->personnelStatus)) && (\App\Personnel::ACTIVE == request()->personnelStatus) ) ? "selected" : '' }}
                                    >فعال</option>
                                    <option value="0"
                                            {{ ( (isset(request()->personnelStatus)) && (\App\Personnel::DE_ACTIVE == request()->personnelStatus) ) ? "selected" : '' }}
                                    >غیرفعال</option>
                                    <option value="2"
                                            {{ ( (isset(request()->personnelStatus)) && (\App\Personnel::DELETED == request()->personnelStatus) ) ? "selected" : '' }}
                                    >حذف شده</option>
                                @endcomponent
                            </div>
                            {{--<div class="form-group col-md-3">--}}
                                {{--@component('components.select-option')--}}
                                    {{--@slot('name', 'centralCost')--}}
                                    {{--@slot('id', 'centralCost')--}}
                                    {{--@slot('label', 'مرکز هزینه:')--}}
                                    {{--<option value=""></option>--}}
                                    {{--@foreach($centralCostService->all() as $key => $centralCost)--}}
                                        {{--<option value="{{ $centralCost->id }}"--}}
                                            {{--{{ ( (isset(request()->centralCost)) && ($centralCost->id == request()->centralCost) ) ? "selected" : '' }}--}}
                                        {{--> {{ $centralCost->title }} </option>--}}
                                    {{--@endforeach--}}
                                {{--@endcomponent--}}
                            {{--</div>--}}
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                @component('components.select2-option')
                                    @slot('name', 'filter[]')
                                    @slot('id', 'filter')
                                    @slot('class', 'js-example-basic-multiple')
                                    @slot('label', 'فیلتر:')
                                    @foreach((new \App\Personnel())->getFilters() as $key => $item)
                                        <option value="{{ $key }}"
                                            @foreach($filters as $selectItem)
                                                {{ ($selectItem == $key) ? 'selected' : null }}
                                            @endforeach
                                        >{{$item}}</option>
                                    @endforeach
                                @endcomponent
                            </div>
                            <div class="form-group col-md-3">
                                @component('components.select-option')
                                    @slot('name', 'job')
                                    @slot('id', 'job')
                                    @slot('label', 'شغل:')
                                    <option value=""></option>
                                    @foreach($jobService->all() as $key => $job)
                                        <option value="{{ $job->id }}"
                                            {{ ((isset(request()->job)) && (request()->job == $job->id)) ? "selected" : '' }}
                                        > {{ $job->title }} </option>
                                    @endforeach
                                @endcomponent
                            </div>
                            <div class="form-group col-md-3">
                                @component('components.select-option')
                                    @slot('name', 'sort')
                                    @slot('id', 'sort')
                                    @slot('label', 'مرتب سازی:')
                                    <option value="asc" {{ (request()->get('sort') == 'asc') ? 'selected' : null }}>صعودی</option>
                                    <option value="desc" {{ (request()->get('sort') == 'desc') ? 'selected' : null }}>نزولی</option>
                                @endcomponent
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                @component('components.submit-button')
                                    @slot('value', 'فیلتر')
                                @endcomponent
                            </div>
                        </div>
                    </form>

                    <!-- tools box -->
                    <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <div class="box-body" style="overflow: scroll">

                    <table class="table table-hover">
                        <tr>
                            <td>شناسه پرسنل</td>

                            @foreach($filters as $item)
                                @if($item != 'id')
                                    <th>{{ (new \App\Personnel())->filters[$item] }}</th>
                                @endif
                            @endforeach

                            @if(request()->has('projects'))
                                <th>پروژه</th>
                            @endif

                            @role([config('roleconst.admin'), config('roleconst.normal')])
                            <th>عملیات</th>
                            @endrole
                        </tr>
                        @foreach($personnels as $key => $personnel)
                            <tr>
                                <td>{{ $personnel->id }}</td>
                                @foreach($filters as $item)
                                    @switch($item)
                                        @case('marital_status')
                                        <td>{{ (! is_null($personnel->marital_status)) ? \App\Personnel::MARITAL_STATUS[$personnel->marital_status] : '' }}</td>
                                        @break

                                        @case('military_status')
                                        <td>{{ (! is_null($personnel->military_status)) ? \App\Personnel::MILITARY_STATUS[$personnel->military_status] : '' }}</td>
                                        @break

                                        @case('education_degree')
                                        <td>{{ (! is_null($personnel->education_degree)) ? \App\Personnel::EDUCATION_DEGREE[$personnel->education_degree] : '' }}</td>
                                        @break

                                        @case('gender')
                                        <td>{{ (! is_null($personnel->gender)) ? \App\Personnel::GENDER[$personnel->gender] : '' }}</td>
                                        @break

                                        @case('job_id')
                                        <td>{{ $personnel->job->title ?? '' }}</td>
                                        @break

                                        @case('central_cost_id')
                                        <td>{{ $personnel->centralCost->title ?? '' }}</td>
                                        @break

                                        @case('organizational_unit_id')
                                        <td>{{ $personnel->organizationalUnit->title ?? '' }}</td>
                                        @break

                                        @case('project_id')
                                        <td>{{ implode("," ,$personnel->projects()->get()->toArray()) ?? '' }}</td>
                                        @break

                                        @case('user_id')
                                        <td>{{ \App\User::find($personnel->user_id)->name }}</td>
                                        @break

                                        @case('updated_at')
                                        <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($personnel->updated_at) }}</td>
                                        @break

                                        @case('birth_date')
                                        <td>{{ (! is_null($personnel->birth_date)) ? (new \App\Services\DateConverter\DateConverter())::toJalali($personnel->birth_date) : '' }}</td>
                                        @break

                                        @default
                                            @if($item != 'id')<td>{{ $personnel->$item ?? '' }}</td>@endif
                                    @endswitch
                                @endforeach

                                @if(request()->has('projects'))
                                    <td>
                                        @foreach($personnel->projects()->get() as $key => $project)
                                            {{ $project->title . ',' }}
                                        @endforeach
                                    </td>
                                @endif

                                @role([config('roleconst.admin'), config('roleconst.normal')])
                                <td>
                                    @if(isset(request()->personnelStatus) && request()->personnelStatus == "2")
                                        <a href="{{ route('personnels.restore', ['personnel' => $personnel->id]) }}" class="btn btn-success btn-xs" title="بازیابی">
                                            <i class="fa fa-rotate-right"></i>&nbsp; بازیابی &nbsp;
                                        </a>
                                    @else
                                        <a href="{{ route('personnels.edit', ['personnel' => $personnel->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                            <i class="fa fa-edit"></i>&nbsp; ویرایش &nbsp;
                                        </a>
                                        <a href="#" data-id="{{ $personnel->id }}" class="btn btn-danger btn-xs" title="حذف">
                                            <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                        </a>
                                    @endif
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $personnels->appends($_GET)->links() }}
                </div>

            </div>
        </section>
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                $('#import_personnel_xls').on('click', function (e) {
                    e.preventDefault();
                    $('#import_personnel_xls_modal').modal("show");
                })

                $('#filter').select2({
                    dir: "rtl",
                    dropdownAutoWidth: true,
                });

                $('#projects').select2({
                    dir: "rtl",
                    dropdownAutoWidth: true,
                });
            });
        </script>
    @endpush

@endsection