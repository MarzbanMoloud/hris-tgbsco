@extends('layouts.main')
@section('title', 'بخش')
@section('content')

    <!-- /.row -->
    <div class="row">
        <section class="col-lg-8 col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title"> ویرایش بخش {{ $organizationalUnit->id }} </h3>

                    <hr>
                    {{--List--}}
                    <div class="form-group">
                        <a href="{{ route('organizationalUnits.index') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-list"></i>
                            لیست واحد (بخش) های سازمان
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

                    <form action="{{ route('organizationalUnits.update', ['organizationalUnit' => $organizationalUnit->id]) }}"
                          method="post">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="organizational_unit_id" value="{{ $organizationalUnit->id }}">

                        {{--Title--}}
                        @component('components.input')
                            @slot('name', 'title')
                            @slot('type', 'text')
                            @slot('id', 'title')
                            @slot('label', 'عنوان')
                            @slot('classWrapper', 'col-md-4')
                            @slot('value', $organizationalUnit->title)
                        @endcomponent

                        <div class="clearfix"></div>

                        {{--SubmitButton--}}
                        @component('components.submit-button')
                            @slot('name', 'create_personnel')
                            @slot('id', 'update_organizational_unit')
                            @slot('classWrapper', 'col-md-4')
                            @slot('value', 'ثبت')
                        @endcomponent

                    </form>

                </div>
            </div>
        </section>
    </div>

@endsection