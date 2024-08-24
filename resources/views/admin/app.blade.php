<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ Storage::url('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/css/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/css/icheck-bootstrap.min.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{asset('assets/css/image-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="{{asset('assets/css/Taginput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/tokenfield.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <style>
        .page-checkbox {
            display: inline-block;
            position: relative;
        }

        .page-checkbox input[type=checkbox] {
            margin: 0;
            visibility: hidden;
            position: absolute;
            left: 1px;
            top: 1px;
        }

        .page-checkbox label {
            width: 35px;
            height: 22px;
            margin: 0;
            border: 3px solid #555;
            border-radius: 100px;
            cursor: pointer;
            display: block;
            overflow: hidden;
            position: relative;
            transition: all 0.75s ease;
        }

        .page-checkbox label:before,
        .page-checkbox label:after {
            content: '';
            background: #555;
            border-radius: 50px;
            width: 14px;
            height: 14px;
            position: absolute;
            top: 1px;
            left: 2px;
            opacity: 1;
            transition: 0.75s ease;
        }

        .page-checkbox label:after {
            left: auto;
            right: 2px;
            opacity: 0;
        }

        .page-checkbox input[type=checkbox]:checked+label {
            border-color: #a30d9e;
            box-shadow: 0 0 5px rgba(163, 13, 158, 0.4);
        }

        .page-checkbox input[type=checkbox]:checked+label:before {
            opacity: 0;
        }

        .page-checkbox input[type=checkbox]:checked+label:after {
            background-color: #a30d9e;
            opacity: 1;
        }

        @media only screen and (max-width:767px) {
            .page-checkbox {
                margin: 0 0 20px;
            }
        }

        .checkbox {
            margin: 0;
            display: inline-block;
            position: absolute;
            top: -17px;
        }

        .checkbox input[type=checkbox] {
            margin: 0;
            visibility: hidden;
            left: 1px;
            top: 1px;
        }

        .checkbox label {
            background: #bbb;
            width: 36px;
            height: 14px;
            min-height: auto;
            padding: 0;
            cursor: pointer;
            border-radius: 50px;
            display: block;
            position: relative;
            z-index: 1;
            transition: all 0.4s ease 0s;
        }

        .checkbox label:before {
            content: '';
            background: #fff;
            width: 20px;
            height: 20px;
            border-radius: 40px;
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2),
                0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 0 0 16px rgba(0, 108, 181, 0);
            transform: translateY(-50%);
            position: absolute;
            top: 50%;
            left: -2px;
            transition: all 0.26s ease 0s;
        }

        .checkbox input[type=checkbox]:checked+label {
            background: #e8ebf1;
            transition: all 0.25s ease 0s;
        }

        .checkbox input[type=checkbox]:checked+label:before {
            background: #0abb75;
            left: 18px;
        }

        @media only screen and (max-width:767px) {
            .checkbox {
                margin: 0 0 20px;
            }
        }
    </style>

    <!-- Scripts -->
    @routes {{-- package hỗ trợ viết route name của Laravel trong javascript --}}
    @vite(['resources/js/admin/app.js', "resources/js/admin/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    <div class="wrapper">
        @inertia
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote-bs4.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('assets/js/image-uploader.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/main_ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#summernote').summernote({
                height: 200,
            });

            $(function() {

                $('input[name="datefilter"]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });

                $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate
                        .format('MM/DD/YYYY'));
                });

                $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });

            });

            $(function() {
                $('input[name="datetimes"]').daterangepicker({
                    timePicker: true,
                    locale: {
                        format: 'M/DD/Y hh:mm A',
                    }
                });
            });

        });
    </script>
</body>

</html>