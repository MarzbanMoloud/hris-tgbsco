@extends('layouts.main')
@section('title', 'شغل')
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
                    <h3 class="box-title"> ویرایش رویداد {{ $event->id }} </h3>

                    <hr>
                    {{--List--}}
                    <div class="form-group">
                        <a href="{{ route('events.index') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-list"></i>
                            لیست رویدادها
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

                    @include('common.validation')

                    <form action="{{ route('events.update', ['event' => $event->id]) }}" method="post">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        {{--Title--}}
                        @component('components.input')
                            @slot('name', 'title')
                            @slot('type', 'text')
                            @slot('id', 'title')
                            @slot('label', 'عنوان')
                            @slot('value', $event->title)
                            @slot('classWrapper', 'col-md-6')
                            @slot('required', 'required')
                        @endcomponent

                        {{--AlertDate--}}
                        @component('components.input')
                            @slot('type', 'text')
                            @slot('name', 'alert_date')
                            @slot('id', 'alert_date')
                            @slot('label', 'تاریخ رویداد')
                            @slot('classWrapper', 'col-md-6')
                            @if(! is_null($event->alert_date))
                                @slot('value', $dateConverter::toJalali($event->alert_date))
                            @endif
                        @endcomponent

                        <div class="clearfix"></div>

                        {{--Caption--}}
                        @component('components.textarea')
                            @slot('name', 'caption')
                            @slot('id', 'caption')
                            @slot('rows', 2)
                            @slot('label', 'متن')
                            @slot('classWrapper', 'col-md-12')
                            @slot('value', $event->caption)
                        @endcomponent

                        <div class="clearfix"></div>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'update_event')
                            @slot('classWrapper', 'col-md-4')
                            @slot('value', 'ثبت')
                        @endcomponent

                    </form>

                </div>
            </div>
        </section>
    </div>

    @push('js')
        <script>
            var customOptions = {
                placeholder: "روز / ماه / سال"
                , twodigit: false
                , closeAfterSelect: false
                , nextButtonIcon: "fa fa-arrow-circle-right"
                , previousButtonIcon: "fa fa-arrow-circle-left"
                , buttonsColor: "blue"
                , forceFarsiDigits: true
                , markToday: true
                , markHolidays: true
                , highlightSelectedDay: true
                , sync: true
                , gotoToday: true
            };

            kamaDatepicker('alert_date', customOptions);
        </script>
    @endpush

@endsection