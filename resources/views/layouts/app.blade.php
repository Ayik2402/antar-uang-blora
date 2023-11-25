<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>ADMIN KLIK BLORA ARTHA</title>
    <!-- <link rel="icon" type="image/x-icon" href="{{asset('/logo/Frame1.png')}}" /> -->
    @vite(['resources/sass/app.scss'])
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/authentication/form-1.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/forms/switches.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="form">
    @yield('content')

    <script src="{{asset('admin/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('admin/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('admin/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/authentication/form-1.js')}}"></script>

</body>

</html>