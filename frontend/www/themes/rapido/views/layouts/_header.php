<!-- start: TOPBAR -->
<header class="topbar navbar navbar-inverse navbar-fixed-top inner">
    <!-- start: TOPBAR CONTAINER -->
    <div class="container">
        <div class="navbar-header">
            <a class="sb-toggle-left hidden-md hidden-lg" href="#main-navbar">
                <i class="fa fa-bars"></i>
            </a>
            <!-- start: LOGO -->
            <a class="navbar-brand" href="/">
                <?= Yii::app()->name ?>
            </a>
            <!-- end: LOGO -->
        </div>
        <div class="topbar-tools">
            <!-- start: TOP NAVIGATION MENU -->
            <ul class="nav navbar-right">
                <?php if (!Yii::app()->user->isGuest) { ?>
                    <!-- start: USER DROPDOWN -->
                    <li class="dropdown current-user">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <span class="username hidden-xs"><?php echo ucfirst(Yii::app()->user->name); ?></span> <i class="fa fa-caret-down "></i>
                        </a>
                        <ul class="dropdown-menu dropdown-dark">
                            <li>
                                <a href="/user/profile">My Profile</a>
                            </li>
                            <li>
                                <a href="/user/logout">Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- end: USER DROPDOWN -->
                <?php } ?>
                <li class="right-menu-toggle">
                    <a href="#" class="sb-toggle-right">
                        <i class="fa fa-globe toggle-icon"></i> <i class="fa fa-caret-right"></i> <span class="notifications-count badge badge-default hide"> 3</span>
                    </a>
                </li>
            </ul>
            <!-- end: TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- end: TOPBAR CONTAINER -->
</header>
<!-- end: TOPBAR -->
