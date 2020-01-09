@extends('layouts.main')
@section('title', 'مرکز هزینه')
@section('content')

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title"> لیست مراکز هزینه </h3>

                    <hr>
                    {{--Create--}}
                    <div class="form-group">
                        <a href="{{ route('centralCosts.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد مرکز هزینه جدید
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
                            <th>آخرین ویرایش</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($centralCosts as $key => $centralCost)
                            <tr>
                                <td>{{ $centralCost->id }}</td>
                                <td>{{ $centralCost->title }}</td>
                                <td>{{ \App\User::find($centralCost->user_id)->name }}</td>
                                <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($centralCost->updated_at) }}</td>
                                <td>
                                    <a href="{{ route('centralCosts.edit', ['centralCost' => $centralCost->id]) }}" class="btn btn-primary btn-sm" title="ویرایش">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $centralCosts->links() }}
                </div>

            </div>
        </section>
    </div>

@endsection