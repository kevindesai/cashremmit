<!DOCTYPE html>
<html lang="en" class="coming-soon">
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="author" content="KaijuThemes">

        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600' rel='stylesheet' type='text/css'>
        <link href="{{ url('/') }}/assets/plugins/iCheck/skins/minimal/blue.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
        <link href="{{ url('/') }}/assets/fonts/themify-icons/themify-icons.css" type="text/css" rel="stylesheet">               <!-- Themify Icons -->
        <link href="{{ url('/') }}/assets/css/styles.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
        <!--[if lt IE 9]>
            <link href="assets/css/ie8.css" type="text/css" rel="stylesheet">
            <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- The following CSS are included as plugins and can be removed if unused-->

    </head>

    <body class="focused-form animated-content">



        @yield('content')


        <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

        <script src="{{ url('/') }}/assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
        <script src="{{ url('/') }}/assets/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
        <script src="{{ url('/') }}/assets/js/bootstrap.min.js"></script> 
 								<!-- Load Bootstrap -->
        <script src="{{ url('/') }}/assets/js/enquire.min.js"></script> 									<!-- Load Enquire -->

        <script src="{{ url('/') }}/assets/plugins/velocityjs/velocity.min.js"></script>					<!-- Load Velocity for Animated Content -->
        <script src="{{ url('/') }}/assets/plugins/velocityjs/velocity.ui.min.js"></script>

        <script src="{{ url('/') }}/assets/plugins/wijets/wijets.js"></script>     						<!-- Wijet -->

        <script src="{{ url('/') }}/assets/plugins/sparklines/jquery.sparklines.min.js"></script> 			 <!-- Sparkline -->


        <script src="{{ url('/') }}/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

        <script src="{{ url('/') }}/assets/js/application.js"></script>
<!--        <script src="{{ url('/') }}/assets/demo/demo.js"></script>
        <script src="{{ url('/') }}/assets/demo/demo-switcher.js"></script>-->

        <!-- End loading site level scripts -->
        <!-- Load page level scripts-->


        <!-- End loading page level scripts-->
    </body>
</html>