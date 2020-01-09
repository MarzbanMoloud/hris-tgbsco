@extends('layouts.main')
@section('title', 'اطلاعات حقوقی')
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
                    <h3 class="box-title"> لیست اطلاعات حقوقی </h3>

                    <hr>

                    <form action="{{ route('salaries.filter') }}" method="get" style="background-color: #ddd; border-radius: 5px; padding: 10px">
                        {{--@csrf--}}

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
                                            {{ ( (isset(request()->personnelStatus)) && (1 == request()->personnelStatus) ) ? "selected" : '' }}
                                    >فعال</option>
                                    <option value="0"
                                            {{ ( (isset(request()->personnelStatus)) && (0 == request()->personnelStatus) ) ? "selected" : '' }}
                                    >غیرفعال</option>
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

                            <th>عملیات</th>
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
                                <td>
                                    @component('components.submit-button')
                                        @slot('name', 'submit_amounts')
                                        @slot('classWrapper', 'col-md-4')
                                        @slot('class', 'btn btn-primary btn-xs submit_amounts')
                                        @slot('value', 'اطلاعات حقوقی')
                                        @slot('dataId', $personnel->id)
                                    @endcomponent
                                </td>
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

                $('.submit_amounts').on('click', function () {
                    var personnelId = $(this).attr('data-id');
                    $('#legal-info-header').html(personnelId);
                    $('#legal-info-input').val(personnelId);

                    $.ajax({
                        type: "get",
                        url: "/salaries/amounts/" + personnelId,
                        success: function(data){
                            $('#insurance_amount').val(data.insurance_amount);
                            $('#benefit_of_amount').val(data.benefit_of_amount);
                            formatCurrency($('#insurance_amount'));
                            formatCurrency($('#benefit_of_amount'));
                            console.log(data);
                        },
                        error: function(data){
                        }
                    });

                    $('#legal-info').modal("show");
                });
            });
        </script>
    @endpush

@endsection