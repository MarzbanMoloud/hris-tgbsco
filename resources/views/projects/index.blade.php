@extends('layouts.main')
@section('title', 'پروژه')
@section('content')

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title"> لیست پروژه ها </h3>

                    <hr>
                    @role([config('roleconst.admin'), config('roleconst.normal')])
                    {{--Create--}}
                    <div class="form-group">
                        <a href="{{ route('projects.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد پروژه جدید
                        </a>
                    </div>
                    @endrole
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

                    <table class="table table-hover">
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>کاربر</th>
                            <th>تعداد پرسنل فعال</th>
                            <th>آخرین ویرایش</th>
                            @role([config('roleconst.admin'), config('roleconst.normal')])
                            <th>عملیات</th>
                            @endrole
                        </tr>
                        @foreach($projects as $key => $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->title }}</td>
                                <td>{{ \App\User::find($project->user_id)->name }}</td>
                                <td>{{ $project->personnels()->where('end_date', null)->count() }}</td>
                                <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($project->updated_at) }}</td>
                                @role([config('roleconst.admin'), config('roleconst.normal')])
                                <td>
                                    <a href="{{ route('projects.edit', ['projects' => $project->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                        <i class="fa fa-edit"></i>&nbsp; ویرایش &nbsp;
                                    </a>
                                    <a href="#" data-id="{{ $project->id }}" class="btn btn-danger btn-xs" title="حذف">
                                        <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                    </a>
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $projects->links() }}
                </div>

            </div>
        </section>
    </div>

@endsection