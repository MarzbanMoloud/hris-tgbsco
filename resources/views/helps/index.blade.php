@extends('layouts.main')
@section('title', 'مساعده')
@section('content')

    {{--InjectServices - start--}}
    @inject('dateConverter', '\App\Services\DateConverter\DateConverter')
    {{--InjectServices - end--}}

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title"> لیست مساعده ها </h3>

                    <hr>
                    {{--Create--}}
                    <div class="form-group">
                        <a href="{{ route('helps.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد مساعده جدید
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
                            <th>شناسه مساعده</th>
                            <th>نام پرسنل</th>
                            <th>کدپرسنل</th>
                            <th>وضعیت</th>
                            <th>کاربر</th>
                            <th>آخرین ویرایش</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($helps as $key => $help)
                            <tr>
                                <td>{{ $help->id }}</td>
                                <td>{{ $help->personnel()->first()->full_name }}</td>
                                <td>{{ $help->personnel()->first()->personnel_code }}</td>
                                <td>{{ \App\Help::STATUSES[$help->status] ?? '' }}</td>
                                <td>{{ \App\User::find($help->user_id)->name ?? '' }}</td>
                                <td>{{ $dateConverter::toJalali($help->updated_at) }}</td>
                                <td>
                                    <a href="{{ route('helps.edit', ['help' => $help->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                        <i class="fa fa-edit"></i>&nbsp; ویرایش &nbsp;
                                    </a>
                                    <a href="#" data-id="{{ $help->id }}" class="btn btn-danger btn-xs" title="حذف">
                                        <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $helps->links() }}
                </div>

            </div>
        </section>
    </div>

@endsection