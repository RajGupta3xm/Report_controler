
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}">
        <title>Upvade : Admin Panel</title> 
        <meta name="keywords" content="Upvade." />
        <meta name="author" content="Upvade" />
        <link href="https://www.upvade.com.com/admin" rel="canonical" />
        <meta name="Classification" content="Upvade" />
        <meta name="abstract" content="https://www.upvade.com/admin" />
        <meta name="audience" content="All" />
        <meta name="robots" content="index,follow" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:title" content="Upvade Admin Panel" /> 
        <meta property="og:url" content="https://www.upvade.com/admin" /> 
        <meta property="og:site_name" content="upvade" />
        <meta name="googlebot" content="index,follow" />
        <meta name="distribution" content="Global" />
        <meta name="Language" content="en-us" />
        <meta name="doc-type" content="Public" />
        <meta name="site_name" content="upvade" />
        <meta name="url" content="https://www.upvade.com/admin" />
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('assets/css/et-line-font/et-line-font.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/themify-icons/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/simple-lineicon/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatables/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/formwizard/jquery-steps.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dropify.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/font/stylesheet.css')}}">
        <style>
            .text-danger{
                font-size:13px;
            }
        </style>
    </head>

    <body class="login-page sty1">
        @yield('content')
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/plugins/jquery-sparklines/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('assets/plugins/jquery-sparklines/sparkline-int.js')}}"></script>
        <script src="{{asset('assets/plugins/raphael/raphael-min.js')}}"></script>
        <script src="{{asset('assets/lugins/morris/morris.js')}}"></script>
        <script src="{{asset('assets/plugins/functions/dashboard1.js')}}"></script>
        <script src="{{asset('assets/js/demo.js')}}"></script>
    </body>

</html>