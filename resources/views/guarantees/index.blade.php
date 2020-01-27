@extends('layouts.main')
@section('title', 'تضامین')
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
                    <h3 class="box-title"> لیست تضامین </h3>

                    <hr>
                    @role([config('roleconst.admin'), config('roleconst.normal')])
                    {{--Create--}}
                    <div class="form-group">
                        <a href="{{ route('guarantees.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد ضمانت جدید
                        </a>
                    </div>
                    @endrole

                    <form action="{{ route('guarantees.filter') }}" method="get">
                        {{--Personnel--}}
                        @component('components.select-option')
                            @slot('name', 'personnelId')
                            @slot('classWrapper', 'col-md-4')
                            @slot('id', 'personnelId')
                            <option value=""></option>
                            @foreach($personnelService->all() as $key => $personnel)
                                <option value="{{ $personnel->id }}"
                                        {{ (request()->has('personnelId') && request()->input('personnelId') == $personnel->id) ? "selected" : '' }}
                                > {{ $personnel->full_name }} </option>
                            @endforeach
                        @endcomponent

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('id', 'filter_guarantee')
                            @slot('classWrapper', 'col-md-4')
                            @slot('value', 'فیلتر')
                            @slot('style', "margin-top: 18px")
                        @endcomponent
                    </form>
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
                            <th>شناسه ضمانت</th>
                            <th>نام پرسنل</th>
                            <th>کدپرسنل</th>
                            {{--<th>وضعیت</th>--}}
                            <th>کاربر</th>
                            <th>آخرین ویرایش</th>
                            @role([config('roleconst.admin'), config('roleconst.normal')])
                            <th>عملیات</th>
                            @endrole
                        </tr>
                        @foreach($guarantees as $key => $guarantee)
                            <tr>
                                <td>{{ $guarantee->id }}</td>
                                <td>{{ $guarantee->personnel()->first()->full_name }}</td>
                                <td>{{ $guarantee->personnel()->first()->personnel_code }}</td>
                                {{--<td>{{ \App\Guarantee::STATUSES[$guarantee->status] ?? '' }}</td>--}}
                                <td>{{ \App\User::find($guarantee->user_id)->name ?? '' }}</td>
                                <td>{{ $dateConverter::toJalali($guarantee->updated_at) }}</td>
                                @role([config('roleconst.admin'), config('roleconst.normal')])
                                <td>
                                    <a href="{{ route('guarantees.edit', ['guarantee' => $guarantee->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                        <i class="fa fa-edit"></i>&nbsp; ویرایش &nbsp;
                                    </a>
                                    <a href="#" data-id="{{ $guarantee->id }}" class="btn btn-danger btn-xs" title="حذف">
                                        <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                    </a>
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $guarantees->links() }}
                </div>

            </div>
        </section>
    </div>

@endsection