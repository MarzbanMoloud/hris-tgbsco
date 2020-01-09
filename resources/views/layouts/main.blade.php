@include('layouts.header')

<!-- Content Wrapper. Contains page content -->
{{--content-wrapper--}}
<div class="" style="background-color: #ddd9dc;padding-top: 20px; min-height: 885px">

    {{--Flash Message--}}
    @include('common.flash-message')

    <!-- Main content -->
        {{--content--}}
    <section>
      @yield('content')
    </section>

</div>
<!-- /.content-wrapper -->

@include('layouts.footer')