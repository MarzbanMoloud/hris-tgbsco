@extends('layouts.main')
@section('title', 'بخش')
@section('content')

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-list"></i>
                    <h3 class="box-title"> لیست بخش ها </h3>

                    <hr>
                    {{--Create--}}
                    <div class="form-group">
                        <a href="{{ route('organizationalUnits.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد بخش جدید
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

                    <table class="table table-hover">
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>کاربر</th>
                            <th>تعداد پرسنل فعال</th>
                            <th>آخرین ویرایش</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($organizationalUnits as $key => $organizationalUnit)
                            <tr>
                                <td>{{ $organizationalUnit->id }}</td>
                                <td>{{ $organizationalUnit->title }}</td>
                                <td>{{ \App\User::find($organizationalUnit->user_id)->name }}</td>
                                <td>{{ $organizationalUnit->personnel()->where('end_date', null)->count() }}</td>
                                <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($organizationalUnit->updated_at) }}</td>
                                <td>
                                    <a href="{{ route('organizationalUnits.edit', ['organizationalUnit' => $organizationalUnit->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                        <i class="fa fa-edit"></i>&nbsp; ویرایش &nbsp;
                                    </a>
                                    <a href="#" data-id="{{ $organizationalUnit->id }}" class="btn btn-danger btn-xs" title="حذف">
                                        <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $organizationalUnits->links() }}
                </div>

            </div>
        </section>
    </div>

@endsection