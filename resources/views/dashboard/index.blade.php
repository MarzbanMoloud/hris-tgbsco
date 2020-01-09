@extends('layouts.main')
@section('title', 'داشبرد')
@section('content')

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-bell"></i>
                    <h3 class="box-title"> رویداد های هفته جاری </h3>
                    <!-- tools box -->
                    <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <div class="box-body">

                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-striped">

                                <tr>
                                    <th>شناسه</th>
                                    <th>عنوان</th>
                                    <th>متن</th>
                                    <th>ایجاد شده توسط</th>
                                    <th>ویرایش شده توسط</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ رویداد</th>
                                    <th colspan="2">عملیات</th>
                                </tr>
                                @foreach($events as $key => $event)
                                    <tr>
                                        <td>{{ $event->id }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->caption }}</td>
                                        <td>{{ \App\User::find($event->created_by)->name ?? '-' }}</td>
                                        <td>{{ \App\User::find($event->updated_by)->name ?? '-' }}</td>
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
                                        <td>{{ (new \App\Services\DateConverter\DateConverter())::toJalali($event->alert_date) }}</td>
                                        <td>
                                            <a href="{{ route('event.success', ['event' => $event->id]) }}">
                                                <button class="btn btn-success btn-xs" title="تایید"><i class="fa fa-check"></i></button>
                                            </a>
                                            <a href="{{ route('event.canceled', ['event' => $event->id]) }}">
                                                <button class="btn bg-red btn-xs" title="لغو"><i class="fa fa-close"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                </div>
            </div>
        </section>
    </div>

@endsection