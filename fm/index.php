<?php
//echo 1;die;
include("config/config.php");
      if(!isset($_SESSION['uinfoadmin'])) header("Location: login.php");
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="author" content="ViviPro" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Filemanager</title>    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="asset/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="asset/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="asset/css/style.css" />
    <link rel="stylesheet" href="plugin/fonts/font-awesome-4.1.0/css/font-awesome.css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Fixed navbar -->
    <?php include("component/header.php") ?>

    <div class="container mycontainer" ng-app="filemanager">
        <div data-ng-view></div>
    </div>
    <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="asset/js/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script id="holder" src="asset/js/holder.min.js" type="text/javascript"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/angular.min.js"></script>
    <script src="asset/js/angular-route.min.js"></script>
    <script src="plugin/jwplayer/jwplayer.js"></script>
    <script src="asset/js/controller/controller.js"></script>
    <script src="asset/js/controller/file-controller.js"></script>
    <script src="asset/js/controller/hanv.js"></script>
    <script src="asset/js/controller/vietnh.js"></script>
    <script src="asset/js/controller/hungnl.js"></script>
    <script>
        $(function () { $("[data-toggle='tooltip']").tooltip(); });
        $('.tree li a').click(function (e) {
            e.preventDefault();
            $(this).parent().children('ul').toggle(200);
        });
        $('#header_menu .navbar-nav li').click(function () {
            $('#header_menu .navbar-nav li').removeClass();
            $(this).addClass('active');
        });


        var cur_url = document.URL.replace('http://', '');
        a = cur_url.split('/');
        if (a[1].length > 0) {
            $('#' + a[1]).addClass('active');
        }
        function selectText(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select();
            } else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
            }
        }
    </script>
</body>
</html>
