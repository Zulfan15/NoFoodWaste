<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css') }}">
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
<!-- Custom header improvements-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/header-improvements.css') }}">
<!-- Notification styles -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/notification-styles.css') }}">

<!-- Auth user ID for real-time notifications -->
@auth
<meta name="user-id" content="{{ Auth::id() }}">
@endauth

@stack('css')