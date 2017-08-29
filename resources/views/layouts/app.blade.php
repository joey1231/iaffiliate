<!--
 * GenesisUI - Bootstrap 4 Admin Template
 * @version v1.8.1
 * @link https://genesisui.com
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license Commercial
 -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Genius - Bootstrap 4 Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,jQuery,CSS,HTML,RWD,Dashboard">
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}" />
    <title>Dialer Admin</title>

    <!-- Icons -->
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/simple-line-icons.css" rel="stylesheet">

    <!-- Premium Icons -->
    <link href="/assets/css/glyphicons.css" rel="stylesheet">
    <link href="/assets/css/glyphicons-filetypes.css" rel="stylesheet">
    <link href="/assets/css/glyphicons-social.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="/assets/css/style.css" rel="stylesheet">
     <link href="/assets/datatables-editor/css/editor.dataTables.min.css" rel="stylesheet"/>
    @yield('header-assets')
    <script>
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        ]) !!};



    </script>
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-compact'				- Compact Sidebar Navigation (Only icons)

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Footer options
1. 'footer-fixed'						- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden" @yield('vue-app')>
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button">☰</button>
        <a class="navbar-brand" href="#"></a>
        <ul class="nav navbar-nav hidden-md-down float-left">
            <li class="nav-item">
                <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
            </li>

        </ul>
         <ul class="nav navbar-nav ml-auto">
                <li><label style='color:#fff' class='clock'>{{date('Y-m-d  H:i:s')}}</li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
           
            
           
            <li class="nav-item dropdown">
                <a class="nav-link avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                   Account
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>

                   
                    <a class="dropdown-item" href="/logout"><i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
            <li class="nav-item hidden-md-down">
             
            </li>

        </ul>
    </header>

    <div class="app-body">
        <div class="sidebar">

            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('campaign')}}"><i class="icon-speedometer"></i> Dashboard </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i> Campaigns</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('campaign')}}"><i class="icon-people icons"></i> List of Campaigns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('campaign/create')}}"><i class="icon-user-follow "></i>Add Campaigns</a>
                            </li>
                          
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-note"></i> Lander</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('lander/list')}}"><i class="icon-note"></i> List of Lander</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('lander/list/create')}}"><i class="icon-note"></i> Add Lander</a>
                            </li>
                        </ul>
                    </li>
                    
                   
                    <li class="nav-item nav-dropdown">
                       <a class="nav-link"  href="{{ url('report/run-algo')}}"><i class="icon-speech"></i> Manual Run Algorithm</a>
                    </li>
                    
                     <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-note"></i> Scheduler Logs</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/report/log/lander/1')}}"><i class="icon-note"></i> Lander</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/report/log/campaign/2')}}"><i class="icon-note"></i>Campaign</a>
                            </li>
                        </ul>
                    </li>

                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i> Users</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('user')}}"><i class="icon-people icons"></i> List of Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('user/create')}}"><i class="icon-user-follow "></i>Add Users</a>
                            </li>
                          
                        </ul>
                    </li>
                    
                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <main class="main" id="employeer" @yield('vue-props')>

           @yield('breadcrumb')

            <div class="container-fluid">



                @yield('contains')


            </div>
            <!-- /.conainer-fluid -->
        </main>

        

    </div>

    <footer class="app-footer">
        <a href="https://genesisui.com">Hardworking Pinoys</a> © 2017 .
        <span class="float-right">
            Powered by <a href="https://genesisui.com">Hardworking Pinoys</a>
        </span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="/assets/js/libs/jquery.min.js"></script>
    <script src="/assets/js/libs/tether.min.js"></script>
    <script src="/assets/js/libs/bootstrap.min.js"></script>
    <script src="/assets/js/libs/pace.min.js"></script>


    <!-- Plugins and scripts required by all views -->
    <script src="/assets/js/libs/Chart.min.js"></script>


    <!-- GenesisUI main scripts -->

    <script src="/assets/js/app.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
        $(document).ready(function() {
            // Create two variable with the names of the months and days in an array
          
                
            setInterval( function() {
                $.ajax({
                    url:'/time',
                    success:function(data){
                        $('.clock').text(data);
                    }
                })
                }, 1000);   
            })
    </script>>
    @yield('script-assets')

</body>

</html>