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
                                        <option value="{{ $project->id }}"> {{ $project->title }} </option>
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
                                        <option value="{{ $organizationalUnit->id }}"> {{ $organizationalUnit->title }} </option>
                                    @endforeach
                                @endcomponent
                            </div>

                            <div class="form-group col-md-3">
                                @component('components.select-option')
                                    @slot('name', 'personnelStatus')
                                    @slot('id', 'personnelStatus')
                                    @slot('label', 'وضعیت پرسنل:')
                                    <option value=""></option>
                                   @foreach(\App\Personnel::STATUSES as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
                                   @endforeach
                                @endcomponent
                            </div>
                            {{--<div class="form-group col-md-3">--}}
                                {{--@component('components.select-option')--}}
                                    {{--@slot('name', 'centralCost')--}}
                                    {{--@slot('id', 'centralCost')--}}
                                    {{--@slot('label', 'مرکز هزینه:')--}}
                                    {{--<option value=""></option>--}}
                                    {{--@foreach($centralCostService->all() as $key => $centralCost)--}}
                                        {{--<option value="{{ $centralCost->id }}"> {{ $centralCost->title }} </option>--}}
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
                                        <option value="{{ $key }}">{{$item}}</option>
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
                                        <option value="{{ $job->id }}"> {{ $job->title }} </option>
                                    @endforeach
                                @endcomponent
                            </div>
                            <div class="form-group col-md-3">
                                @component('components.select-option')
                                    @slot('name', 'sort')
                                    @slot('id', 'sort')
                                    @slot('label', 'مرتب سازی:')
                                    <option value="asc">صعودی</option>
                                    <option value="desc">نزولی</option>
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
                <div class="box-body">

                    <table class="table table-hover">
                        <tr>
                            <th>شناسه پرسنل</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>شماره پرسنلی</th>
                            <th>کاربر</th>
                            <th>آخرین ویرایش</th>
                            @role([config('roleconst.admin'), config('roleconst.normal')])
                            <th>عملیات</th>
                            @endrole
                        </tr>
                        @foreach($personnels as $key => $personnel)
                            <tr>
                                <td>{{ $personnel->id }}</td>
                                <td> {{ $personnel->first_name }} </td>
                                <td> {{ $personnel->last_name }} </td>
                                <td> {{ $personnel->personnel_code }} </td>
                                <td>{{ \App\User::find($personnel->user_id)->name }}</td>
                                <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($personnel->updated_at) }}</td>

                                @role([config('roleconst.admin'), config('roleconst.normal')])
                                <td>
                                    <a href="{{ route('personnels.edit', ['personnel' => $personnel->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                        <i class="fa fa-edit"></i>&nbsp; ویرایش &nbsp;
                                    </a>
                                    <a href="#" data-id="{{ $personnel->id }}" class="btn btn-danger btn-xs" title="حذف">
                                        <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                    </a>
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $personnels->links() }}
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