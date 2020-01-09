<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | HRIS </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-theme.css') }}">
    <!-- Bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('dist/css/rtl.css') }}">
    <!-- persian Date Picker -->
    <link rel="stylesheet" href="{{ asset('dist/css/persian-datepicker-0.4.5.min') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
          href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- babakhani datepicker -->
    <link rel="stylesheet" href="{{ asset('dist/css/persian-datepicker-0.4.5.min.css') }}"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    {{--Select2--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ asset('css/kamadatepicker.min.css') }}">
    <script src="{{ asset('js/kamadatepicker.js') }}"></script>

    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        .hide{
            display: none;
        }

        label {
            font-size: 12px;
        }

        /*navbar*/
        .navbar-default {
            background-color: #69899f;
            border-color: #425766;
        }
        .navbar-default .navbar-brand {
            color: #d7e2e9;
        }
        .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
            color: #e5dbdb;
        }
        .navbar-default .navbar-text {
            color: #d7e2e9;
        }
        .navbar-default .navbar-nav > li > a {
            color: #d7e2e9;
        }
        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
            color: #e5dbdb;
        }
        .navbar-default .navbar-nav > li > .dropdown-menu {
            background-color: #69899f;
        }
        .navbar-default .navbar-nav > li > .dropdown-menu > li > a {
            color: #d7e2e9;
        }
        .navbar-default .navbar-nav > li > .dropdown-menu > li > a:hover,
        .navbar-default .navbar-nav > li > .dropdown-menu > li > a:focus {
            color: #e5dbdb;
            background-color: #425766;
        }
        .navbar-default .navbar-nav > li > .dropdown-menu > li > .divider {
            background-color: #69899f;
        }
        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
            color: #e5dbdb;
            background-color: #425766;
        }
        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
            color: #e5dbdb;
            background-color: #425766;
        }
        .navbar-default .navbar-toggle {
            border-color: #425766;
        }
        .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
            background-color: #425766;
        }
        .navbar-default .navbar-toggle .icon-bar {
            background-color: #d7e2e9;
        }
        .navbar-default .navbar-collapse,
        .navbar-default .navbar-form {
            border-color: #d7e2e9;
        }
        .navbar-default .navbar-link {
            color: #d7e2e9;
        }
        .navbar-default .navbar-link:hover {
            color: #e5dbdb;
        }

        @media (max-width: 767px) {
            .navbar-default .navbar-nav .open .dropdown-menu > li > a {
                color: #d7e2e9;
            }

            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                color: #e5dbdb;
            }

            .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
                color: #e5dbdb;
                background-color: #425766;
            }
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="">
    {{--Modal - LegalInfo--}}
    <div class="modal fade" id="legal-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <span id="legal-info-header"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form action="{{ route('salaries.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="personnel_id" id="legal-info-input">
                        {{--InsuranceAmount--}}
                        <div class="form-group col-md-12">
                            <label for="insurance_amount">مبلغ بیمه ای:</label>
                            <input class="form-control"
                                   type="text"
                                   name="insurance_amount"
                                   id="insurance_amount"
                                   value=""
                                   data-type="currency"
                                   required
                                   placeholder="1,000,000 ریال">
                        </div>

                        {{--BenefitOfAmount--}}
                        <div class="form-group col-md-12">
                            <label for="benefit_of_amount">مبلغ حقوق و مزایا:</label>
                            <input class="form-control"
                                   type="text"
                                   name="benefit_of_amount"
                                   id="benefit_of_amount"
                                   value=""
                                   data-type="currency"
                                   required
                                   placeholder="1,000,000 ریال">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">ثبت</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Modal - DELETE--}}
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <p> ادامه می دهید؟</p>
                    <p class="debug-url"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-danger btn-ok">حذف</button>
                </div>
            </div>
        </div>
    </div>

    {{--Modal - Import - XLS--}}
    <div class="modal fade" id="import_personnel_xls_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form action="{{ route('excel.import') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file_xls"> فایل مورد نظر خود را انتخاب کنید: (فرمت اکسل) </label>
                            <input type="file" id="file_xls" name="file_xls">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                        <button type="submit" class="btn btn-primary">تایید</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--Modal - Frequently use the facility--}}
    <div class="modal fade" id="frequently-facility" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <p>کاربر منتخب از تسهیلات مورد نظر به تعداد  <span id="frequently-facility-text"></span>  دفعه استفاده کرده است. </p>
                    <p>برای ثبت جدید تسهیلات دکمه ثبت در غیر اینصورت دکمه لغو را کلیک کنید.</p>
                    <p class="debug-url"></p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="frequently-facility-btn">ثبت</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                </div>
            </div>
        </div>
    </div>

    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">HRIS</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav">
                        {{--Dashboard--}}
                        <li class="active"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>داشبرد</span> <span class="sr-only">(current)</span></a></li>

                        {{--Personnel--}}
                        <li class="dropdown">
                            <a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i> <span>پرسنل</span>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('personnels.create') }}"><i class="fa fa-plus"></i> ایجاد پرسنل </a></li>
                                <li><a class="nav-link" href="{{ route('personnels.index') }}"><i class="fa fa-list"></i> لیست پرسنل </a></li>
                            </ul>
                        </li>

                        {{--LegalInformation--}}
                        <li ><a href="{{ route('salaries.index') }}"><i class="fa fa-dollar"></i> <span>اطلاعات حقوقی</span> <span class="sr-only"></span></a></li>

                        {{--OrganizationalUnit--}}
                        <li class="dropdown">
                            <a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bar-chart"></i> <span>واحدهای سازمان</span>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('organizationalUnits.create') }}"><i class="fa fa-plus"></i> ایجاد واحد </a></li>
                                <li><a class="nav-link" href="{{ route('organizationalUnits.index') }}"><i class="fa fa-list"></i> لیست واحدها </a></li>
                            </ul>
                        </li>

                        {{--Job--}}
                        <li class="dropdown">
                            <a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-th"></i> <span>شغل</span>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('jobs.create') }}"><i class="fa fa-plus"></i> ایجاد شغل </a></li>
                                <li><a class="nav-link" href="{{ route('jobs.index') }}"><i class="fa fa-list"></i> لیست شغل ها </a></li>
                            </ul>
                        </li>

                        {{--Project--}}
                        <li class="dropdown">
                            <a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-o"></i> <span>پروژه</span>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('projects.create') }}"><i class="fa fa-plus"></i> ایجاد پروژه </a></li>
                                <li><a class="nav-link" href="{{ route('projects.index') }}"><i class="fa fa-list"></i> لیست پروژه ها </a></li>
                            </ul>
                        </li>

                        {{--Event--}}
                        <li class="dropdown">
                            <a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i> <span>رویداد</span>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{ route('events.create') }}"><i class="fa fa-plus"></i> ایجاد رویداد </a></li>
                                <li><a class="nav-link" href="{{ route('events.index') }}"><i class="fa fa-list"></i> لیست رویداد ها </a></li>
                            </ul>
                        </li>

                        {{--Facility--}}
                        <li class="dropdown">
                            <a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-support"></i> <span>تسهیلات</span>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">

                                {{--Loan--}}
                                <li><a class="nav-link" href="{{ route('loans.index') }}"><i class="fa fa-list"></i>  وام </a></li>

                                {{--Guarantee--}}
                                <li><a class="nav-link" href="{{ route('guarantees.index') }}"><i class="fa fa-list"></i>  تضامین </a></li>

                                {{--Help--}}
                                <li><a class="nav-link" href="{{ route('helps.index') }}"><i class="fa fa-list"></i>  مساعده </a></li>

                                {{--JobCertificate--}}
                                <li><a class="nav-link" href="{{ route('jobCertificates.index') }}"><i class="fa fa-list"></i>  گواهی شغلی </a></li>

                            </ul>
                        </li>

                        {{--<li class="dropdown">--}}
                            {{--<a href="https://www.jquery-az.com/bootstrap-tips-tutorials/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
                                {{--<i class="fa fa-bank"></i> <span>مرکز هزینه</span>--}}
                                {{--<span class="caret"></span></a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li><a class="nav-link" href="{{ route('centralCosts.create') }}"><i class="fa fa-plus"></i> ایجاد مرکز </a></li>--}}
                                {{--<li><a class="nav-link" href="{{ route('centralCosts.index') }}"><i class="fa fa-list"></i> لیست مرکزها </a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" class="btn btn-default btn-flat" value="خروج">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>

    {{--<header class="main-header">--}}
        {{--<!-- Logo -->--}}
        {{--<a href="#" class="logo">--}}
            {{--<!-- mini logo for sidebar mini 50x50 pixels -->--}}
            {{--<span class="logo-mini">پنل</span>--}}
            {{--<!-- logo for regular state and mobile devices -->--}}
            {{--<span class="logo-lg"><b>HRIS</b></span>--}}
        {{--</a>--}}
        <!-- Header Navbar: style can be found in header.less -->
        {{--<nav class="navbar navbar-static-top">--}}
            {{--<!-- Sidebar toggle button-->--}}
            {{--<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
            {{--</a>--}}

            {{--<div class="navbar-custom-menu">--}}
                {{--<ul class="nav navbar-nav">--}}
                    {{--<!-- User Account: style can be found in dropdown.less -->--}}
                    {{--<li class="dropdown user user-menu">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                            {{--<img src="{{ asset('images/account-user-icon.png') }}" class="user-image" alt="User Image">--}}
                            {{--<span class="hidden-xs">{{ auth()->user()->name }}</span>--}}
                        {{--</a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<!-- User image -->--}}
                            {{--<li class="user-header">--}}
                                {{--<img src="{{ asset('images/account-user-icon.png') }}" class="img-circle"--}}
                                     {{--alt="User Image">--}}
                                {{--<p>--}}
                                    {{--{{ auth()->user()->name }}--}}
                                    {{--@foreach(auth()->user()->roles()->get() as $key => $role)--}}
                                        {{--<small>{{ $role['display_name'] }}</small>--}}
                                    {{--@endforeach--}}
                                {{--</p>--}}
                            {{--</li>--}}
                            {{--<!-- Menu Body -->--}}
                            {{--<li class="user-body">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">صفحه من</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">فروش</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">دوستان</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- /.row -->--}}
                            {{--</li>--}}
                            {{--<!-- Menu Footer-->--}}
                            {{--<li class="user-footer">--}}
                                {{--<div class="pull-right">--}}
                                    {{--<a href="#" class="btn btn-default btn-flat">پروفایل</a>--}}
                                {{--</div>--}}
                                {{--<div class="pull-left">--}}
                                    {{--<form action="{{ route('logout') }}" method="post">--}}
                                        {{--@csrf--}}
                                        {{--<input type="submit" class="btn btn-default btn-flat" value="خروج">--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<!-- Control Sidebar Toggle Button -->--}}
                    {{--<li>--}}
                        {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</nav>--}}
    {{--</header>--}}
    <!-- right side column. contains the logo and sidebar -->
    {{--<aside class="main-sidebar">--}}
        {{--<!-- sidebar: style can be found in sidebar.less -->--}}
        {{--<section class="sidebar">--}}
            {{--<!-- Sidebar user panel -->--}}
            {{--<div class="user-panel">--}}
                {{--<div class="pull-right image">--}}
                    {{--<img src="{{ asset('images/account-user-icon.png') }}" class="img-circle" alt="User Image">--}}
                {{--</div>--}}
                {{--<div class="pull-right info">--}}
                    {{--<p>{{ auth()->user()->name }}</p>--}}
                    {{--<a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- search form -->--}}
            {{--<form action="#" method="get" class="sidebar-form">--}}
                {{--<div class="input-group">--}}
                    {{--<input type="text" name="q" class="form-control" placeholder="جستجو">--}}
                    {{--<span class="input-group-btn">--}}
                {{--<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
                {{--</button>--}}
              {{--</span>--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--<!-- /.search form -->--}}
            {{--<!-- sidebar menu: : style can be found in sidebar.less -->--}}
            {{--<ul class="sidebar-menu" data-widget="tree">--}}
                {{--<li class="header">منو</li>--}}

                {{--Dashboard--}}
                {{--<li>--}}
                    {{--<a href="{{ route('dashboard') }}">--}}
                        {{--<i class="fa fa-dashboard"></i> <span>داشبرد</span>--}}
                        {{--<span class="pull-left-container"></span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--Personnel--}}
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-user"></i> <span>پرسنل</span>--}}
                        {{--<span class="pull-left-container">--}}
                            {{--<i class="fa fa-angle-right pull-left"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ route('personnels.create') }}"><i class="fa fa-plus"></i> ایجاد پرسنل </a></li>--}}
                        {{--<li><a href="{{ route('personnels.index') }}"><i class="fa fa-list"></i> لیست پرسنل </a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                {{--OraganizationalUnit--}}
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-bar-chart"></i> <span>واحد|بخش</span>--}}
                        {{--<span class="pull-left-container">--}}
                            {{--<i class="fa fa-angle-right pull-left"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ route('organizationalUnits.create') }}"><i class="fa fa-plus"></i> ایجاد بخش--}}
                            {{--</a></li>--}}
                        {{--<li><a href="{{ route('organizationalUnits.index') }}"><i class="fa fa-list"></i> لیست بخش ها--}}
                            {{--</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                {{--Job--}}
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-th"></i> <span>شغل</span>--}}
                        {{--<span class="pull-left-container">--}}
                            {{--<i class="fa fa-angle-right pull-left"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ route('jobs.create') }}"><i class="fa fa-plus"></i> ایجاد شغل </a></li>--}}
                        {{--<li><a href="{{ route('jobs.index') }}"><i class="fa fa-list"></i> لیست مشاغل </a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                {{--Project--}}
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-file-o"></i> <span>پروژه</span>--}}
                        {{--<span class="pull-left-container">--}}
                            {{--<i class="fa fa-angle-right pull-left"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ route('projects.create') }}"><i class="fa fa-plus"></i> ایجاد پروژه </a></li>--}}
                        {{--<li><a href="{{ route('projects.index') }}"><i class="fa fa-list"></i> لیست پروژه ها </a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                {{--Event--}}
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-bell"></i> <span>رویداد</span>--}}
                        {{--<span class="pull-left-container">--}}
                            {{--<i class="fa fa-angle-right pull-left"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ route('events.create') }}"><i class="fa fa-plus"></i> ایجاد رویداد </a></li>--}}
                        {{--<li><a href="{{ route('events.index') }}"><i class="fa fa-list"></i> لیست رویداد ها </a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                {{--CentralCost--}}
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-bank"></i> <span>مرکز هزینه</span>--}}
                        {{--<span class="pull-left-container">--}}
                            {{--<i class="fa fa-angle-right pull-left"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ route('centralCosts.create') }}"><i class="fa fa-plus"></i> ایجاد مرکز </a></li>--}}
                        {{--<li><a href="{{ route('centralCosts.index') }}"><i class="fa fa-list"></i> لیست مراکز </a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

            {{--</ul>--}}
        {{--</section>--}}
        {{--<!-- /.sidebar -->--}}
    {{--</aside>--}}
