<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin | Cash remmit</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="description" content="december Admin Theme">
        <meta name="author" content="KaijuThemes">
        <script src="<?php echo e(url('/')); ?>/assets/js/jquery-1.10.2.min.js"></script> 	
        <script src="<?php echo e(url('/')); ?>/assets/plugins/form-parsley/parsley.js"></script>   
        <script src="<?php echo e(url('/')); ?>/js/relcopy.js"></script>   
        <link type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet'>

        <link href="<?php echo e(url('/')); ?>/assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">          
        <link href="<?php echo e(url('/')); ?>/assets/fonts/themify-icons/themify-icons.css" type="text/css" rel="stylesheet">              <!-- Themify Icons -->
        <link href="<?php echo e(url('/')); ?>/assets/css/styles.css" type="text/css" rel="stylesheet">                                     <!-- Core CSS with all styles -->

        <link href="<?php echo e(url('/')); ?>/assets/plugins/codeprettifier/prettify.css" type="text/css" rel="stylesheet">                <!-- Code Prettifier -->
        <link href="<?php echo e(url('/')); ?>/assets/plugins/iCheck/skins/minimal/blue.css" type="text/css" rel="stylesheet">              <!-- iCheck -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!--[if lt IE 10]>
            <script src="<?php echo e(url('/')); ?>/assets/js/media.match.min.js"></script>
            <script src="<?php echo e(url('/')); ?>/assets/js/respond.min.js"></script>
            <script src="<?php echo e(url('/')); ?>/assets/js/placeholder.min.js"></script>
        <![endif]-->
        <!-- The following CSS are included as plugins and can be removed if unused-->

        <link href="<?php echo e(url('/')); ?>/assets/plugins/form-daterangepicker/daterangepicker-bs3.css" type="text/css" rel="stylesheet">    <!-- DateRangePicker -->
        <link href="<?php echo e(url('/')); ?>/assets/plugins/fullcalendar/fullcalendar.css" type="text/css" rel="stylesheet"> 						<!-- FullCalendar -->
        <link href="<?php echo e(url('/')); ?>/assets/plugins/switchery/switchery.css" type="text/css" rel="stylesheet">   							<!-- Switchery -->

    </head>

    <body class="animated-content infobar-overlay">

        <header id="topnav" class="navbar navbar-default navbar-fixed-top" role="banner">

            <div class="logo-area">
                <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
                    <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
                        <span class="icon-bg">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                    </a>
                </span>

                <a class="navbar-brand" href="#">Cash Remmit</a>


                <!--                <div class="toolbar-icon-bg hidden-xs" id="toolbar-search">
                                    <div class="input-group">
                                        <span class="input-group-btn"><button class="btn" type="button"><i class="fa fa-search"></i></button></span>
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <span class="input-group-btn"><button class="btn" type="button"><i class="fa fa-close"></i></button></span>
                                    </div>
                                </div>-->
            </div><!-- logo-area -->

            <ul class="nav navbar-nav toolbar pull-right">

                <li class="toolbar-icon-bg visible-xs-block" id="trigger-toolbar-search">
                    <a href="#"><span class="icon-bg"><i class="fa fa-search"></i></span></a>
                </li>

                <li class="dropdown toolbar-icon-bg hidden-xs">
                    <a href="#" class="dropdown-toggle nav-username" data-toggle="dropdown">
                        <img class="img-circle" src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_06.png" alt="" /><span class="badge user-status badge-success">1</span>
                        <span class="hidden-sm"><?php echo e(Auth::user()->name); ?></span>
                    </a>			
                    <ul class="dropdown-menu userinfo">
                        <li><a href="<?php echo e(url('/')); ?>/admin/profile"><i class="fa fa-user"></i><span>Profile</span></a></li>
                        <li><a href="<?php echo e(url('/')); ?>/admin/password"><i class="fa fa-wrench"></i><span>Change Password</span></a></li>
                        <li><a href="<?php echo e(url('/')); ?>/admin/logout"><i class="fa fa-power-off"></i><span>Sign Out</span></a></li>
                    </ul>
                </li>

                <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
                    <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="fa fa-arrows-alt"></i></span></i></a>
                </li>



            </ul>

        </header>

        <div id="wrapper">
            <div id="layout-static">
                <div class="static-sidebar-wrapper sidebar-default">
                    <div class="static-sidebar">
                        <div class="sidebar">

                            <div class="widget stay-on-collapse" id="widget-sidebar">
                                <nav role="navigation" class="widget-body">
                                    <ul class="acc-menu">
                                        <li><a href="<?php echo e(url('/')); ?>/admin/users"><i class="fa fa-user"></i><span>Users</span></a></li>
                                        <li><a href="<?php echo e(url('/')); ?>/admin/country"><i class="fa fa-bookmark"></i><span>Country</span></a></li>
                                        <li><a href="<?php echo e(url('/')); ?>/admin/rate/list"><i class="fa fa-bookmark"></i><span>Manage Rate</span></a></li>
                                        <li><a href="<?php echo e(url('/')); ?>/admin/promossion"><i class="fa fa-bookmark"></i><span>Promossion</span></a></li>
                                        <li><a href="<?php echo e(url('/')); ?>/admin/banks"><i class="fa fa-bookmark"></i><span>Banks</span></a></li>
                                        <li><a href="<?php echo e(url('/')); ?>/admin/transferrate"><i class="fa fa-bookmark"></i><span>Transfer Rate</span></a></li>

                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <!--                            <ol class="breadcrumb">
                            
                                                            <li class=""><a href="index.html">Home</a></li>
                                                            <li class="active"><a href="index.html">Dashboard</a></li>
                            
                                                        </ol>-->
                            <div class="page-heading">            
                                <!--<h1>Dashboard</h1>-->
                                <?php echo $__env->yieldContent('header'); ?>
                                <!--                                <div class="options">
                                                                    <div class="btn-toolbar">
                                                                        <form action="" class="form-horizontal row-border" style="display: inline-block;">
                                                                            <div class="form-group hidden-xs">
                                                                                <div class="col-sm-8">
                                                                                    <button class="btn btn-default" id="daterangepicker-d">
                                                                                        <i class="fa fa-calendar"></i> 
                                                                                        <span><?php echo date("F j, Y"); ?></span> <b class="caret"></b>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div> -->
                            </div>
                            <div class="container-fluid">


                                <?php echo $__env->yieldContent('content'); ?>

                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
                    </div>
                    <footer role="contentinfo">
                        <div class="clearfix">
                            <ul class="list-unstyled list-inline pull-left">
                                <li><h6 style="margin: 0;">&copy; Cash Remmit</h6></li>
                            </ul>
                            <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
                        </div>
                    </footer>

                </div>
            </div>
        </div>

        <div class="infobar-wrapper scroll-pane">
            <div class="infobar scroll-content">

                <div id="widgetarea">

                    <div class="widget" id="widget-sparkline">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#sparklinestats"><h4>Project Status</h4></a>
                        </div>
                        <div id="sparklinestats" class="collapse in">
                            <div class="widget-body">
                                <ul class="sparklinestats">
                                    <li class="col-md-4 col-sm-4 col-xs-4">
                                        <h3>$39K</h3>
                                        <span>Expenses</span>
                                    </li>
                                    <li class="col-md-4 col-sm-4 col-xs-4">
                                        <h3>$11K</h3>
                                        <span>Net Profit</span>
                                    </li>
                                    <li class="col-md-4 col-sm-4 col-xs-4">
                                        <h3>$29K</h3>
                                        <span>Total Sales</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="widget" id="widget-piechart">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#piechartstats"><h4>Chart</h4></a>
                        </div>
                        <div id="piechartstats" class="collapse in">
                            <div class="widget-body">
                                <li class="chart-label"><span>Earnings this week</span></li>
                                <div id="bigline"></div>
                            </div>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#recentactivity"><h4>Meetings</h4></a>
                        </div>
                        <div id="recentactivity" class="collapse in">
                            <div class="widget-body">
                                <div class="recent-activities">
                                    <div>
                                        <h5 class="report-status">Design</h5>
                                        <span class="report-time">1:12PM, Thursday, November 19, 2015</span>
                                        <ul class="user-avatar list-inline">
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_01.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_02.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_03.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_04.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_05.png" class="img-responsive avatar"> 
                                            </li>
                                        </ul>
                                        <button class="btn btn-success"><i class="fa fa-check"></i></button>
                                    </div>

                                    <div>
                                        <h5 class="report-status">Development</h5>
                                        <span class="report-time">11:40AM, Sunday, November 22, 2015</span>
                                        <ul class="user-avatar list-inline">
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_06.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_07.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_08.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_09.png" class="img-responsive avatar"> 
                                            </li>
                                            <li class="">
                                                <img src="<?php echo e(url('/')); ?>/assets/demo/avatar/avatar_10.png" class="img-responsive avatar"> 
                                            </li>
                                        </ul>
                                        <button class="btn btn-default disabled"><i class="fa fa-undo"></i></button>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#widget-contact"><h4>Contacts</h4></a>
                        </div>
                        <div id="widget-contact" class="collapse in">
                            <div class="widget-body">
                                <ul class="contact-list">
                                    <li id="contact-1">
                                        <a>
                                            <h5>Dashboard design</h5>
                                            <span>4 members, 5 jobs</span>
                                        </a>                               
                                    </li>
                                    <li id="contact-2">
                                        <a>
                                            <h5>Profile page psd</h5>
                                            <span>4 members, 5 jobs</span>                               
                                        </a>
                                    </li>
                                    <li id="contact-3">
                                        <a>
                                            <h5>Documentation</h5>
                                            <span>4 members, 5 jobs</span>                               
                                        </a>
                                    </li>
                                    <li id="contact-4">
                                        <a>
                                            <h5>Plugins</h5>
                                            <span>4 members, 5 jobs</span>                                
                                        </a>
                                    </li>
                                    <li id="contact-5">
                                        <a>
                                            <h5>App development</h5>
                                            <span>4 members, 5 jobs</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>


        <!-- Load site level scripts -->

        <?php echo $__env->yieldContent('script'); ?>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

        <!-- Load jQuery -->
        <script src="<?php echo e(url('/')); ?>/assets/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
        <script src="<?php echo e(url('/')); ?>/assets/js/bootstrap.min.js"></script> 	
        <!-- End loading page level scripts-->
        <script src="<?php echo e(url('/')); ?>/assets/js/enquire.min.js"></script> 									<!-- Load Enquire -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/velocityjs/velocity.min.js"></script>					<!-- Load Velocity for Animated Content -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/velocityjs/velocity.ui.min.js"></script>

        <script src="<?php echo e(url('/')); ?>/assets/plugins/wijets/wijets.js"></script>     						<!-- Wijet -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/sparklines/jquery.sparklines.min.js"></script> 			 <!-- Sparkline -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

        <script src="<?php echo e(url('/')); ?>/assets/js/application.js"></script>
        <script src="<?php echo e(url('/')); ?>/assets/demo/demo.js"></script>
        <script src="<?php echo e(url('/')); ?>/assets/demo/demo-switcher.js"></script>

        <!-- End loading site level scripts -->

        <!-- Load page level scripts-->

        <!-- Charts -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/charts-flot/jquery.flot.min.js"></script>             	<!-- Flot Main File -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/charts-flot/jquery.flot.pie.min.js"></script>             <!-- Flot Pie Chart Plugin -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/charts-flot/jquery.flot.stack.min.js"></script>       	<!-- Flot Stacked Charts Plugin -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/charts-flot/jquery.flot.resize.min.js"></script>          <!-- Flot Responsive -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/charts-flot/jquery.flot.tooltip.min.js"></script> 		<!-- Flot Tooltips -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/charts-flot/jquery.flot.spline.js"></script> 				<!-- Flot Curved Lines -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/switchery/switchery.js"></script>     					<!-- Switchery -->
        <script src="<?php echo e(url('/')); ?>/assets/plugins/form-daterangepicker/moment.min.js"></script>              <!-- Moment.js for Date Range Picker -->

        <script src="<?php echo e(url('/')); ?>/assets/plugins/form-daterangepicker/daterangepicker.js"></script>     	<!-- Date Range Picker -->
        <!-- Date Range Picker -->


        <script src="<?php echo e(url('/')); ?>/assets/demo/demo-index.js"></script> 									<!-- Initialize scripts for this page-->


    </body>
</html>