<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Aurelle | Store</title>

<!-- Favicons -->
<link rel="shortcut icon" href="{{ url('admin_assets/img/favicon.png') }}">

<!-- Select 2 -->
<link rel="stylesheet" href="{{ url('/admin_assets/css/select2.min.css') }}">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('admin_assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}">

<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ url('/admin_assets/plugins/fontawesome/css/all.min.css') }}">

@if (Route::is(['security']))
    <!-- Mobile CSS-->
    <link rel="stylesheet" href="{{ url('/admin_assets/plugins/intltelinput/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ url('/admin_assets/plugins/intltelinput/css/demo.css') }}">
@endif

@if (Route::is(['calendar-settings']))
    <!-- Full Calander CSS -->
    <link rel="stylesheet" href="{{ url('/admin_assets/plugins/fullcalendar/fullcalendar.min.css') }}">
@endif

<!-- Map CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}">

<!-- Datatable CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/css/dataTables.bootstrap4.min.css') }}">

<!-- Feather CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/plugins/feather/feather.css') }}">

<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/css/bootstrap-datetimepicker.min.css') }}">

<!-- Ck Editor -->
<link rel="stylesheet" href="{{ url('/admin_assets/css/ckeditor.css') }}">

@if (Route::is(['view-service']))
    <!-- Owl carousel CSS -->
    <link rel="stylesheet" href="{{ url('/admin_assets/css/owl.carousel.min.css') }}">
@endif
@if (Route::is(['view-service']))
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="{{ url('/assets/plugins/fancybox/jquery.fancybox.min.css') }}">
@endif
<!-- Main CSS -->
<link rel="stylesheet" href="{{ url('/admin_assets/css/admin.css') }}">
