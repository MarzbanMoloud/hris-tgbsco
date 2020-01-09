@extends('layouts.main')
@section('title', 'شغل')
@section('content')

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title"> لیست رویدادها </h3>

                    <hr>
                    {{--Create--}}
                    <div class="form-group">
                        <a href="{{ route('events.create') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            ایجاد رویداد جدید
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
                            <th>وضعیت</th>
                            <th>ایجاد شده توسط</th>
                            <th>ویرایش شده توسط</th>
                            <th>آخرین ویرایش</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($events as $key => $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->title }}</td>
                                <td>
                                    @switch($event->status)
                                        @case(\App\Event::SUCCESS)
                                        <span class="label label-success">تایید شده</span>
                                        @break

                                        @case(\App\Event::CANCELED)
                                        <span class="label label-danger">لغو شده</span>
                                        @break

                                        @case(\App\Event::INITIATE)
                                        <span class="label label-warning">در انتظار</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>{{ \App\User::find($event->created_by)->name ?? "-" }}</td>
                                <td>{{ \App\User::find($event->updated_by)->name ?? "-" }}</td>
                                <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($event->updated_at) }}</td>
                                <td>
                                    <a href="{{ route('event.success', ['event' => $event->id]) }}">
                                        <button class="btn btn-success btn-xs" title="تایید"><i class="fa fa-check"></i></button>
                                    </a>
                                    <a href="{{ route('event.canceled', ['event' => $event->id]) }}">
                                        <button class="btn btn-xs bg-red" title="لغو"><i class="fa fa-close"></i></button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('events.edit', ['event' => $event->id]) }}" class="btn btn-primary btn-xs" title="ویرایش">
                                        <i class="fa fa-edit"></i> &nbsp; ویرایش &nbsp;
                                    </a>
                                    <a href="#" data-id="{{ $event->id }}" class="btn btn-danger btn-xs" title="حذف">
                                        <i class="fa fa-trash"></i>&nbsp; حذف &nbsp;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>

                <div class="text-center">
                    {{ $events->links() }}
                </div>

            </div>
        </section>
    </div>

@endsection