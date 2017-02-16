<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header_menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">File Management</a>
        </div>
        <div class="navbar-collapse collapse" id="header_menu">
            <ul class="nav navbar-nav">
                <li id="explorer"><a href="#/explorer">Explorer</a></li>
                <!--<li id="upload"><a href="#/upload/">Uploads</a></li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <input type="hidden" value="<?php echo $_SESSION['uinfoadmin'];?>" id="token">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Xin chào <b><?php echo $_SESSION['uinfoadmin'];?></b> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Cài đặt</a></li>
                        <li><a ng-href="/fm/logout.php" href="/fm/logout.php">Thoát</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
