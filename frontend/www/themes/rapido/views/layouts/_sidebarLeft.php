<!-- start: PAGESLIDE LEFT -->
<a class="closedbar inner hidden-sm hidden-xs" href="#">
</a>
<nav id="pageslide-left" class="pageslide inner">
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <div class="main-navigation left-wrapper transition-left">
            <div class="navigation-toggler hidden-sm hidden-xs">
                <a href="#main-navbar" class="sb-toggle-left">
                </a>
            </div>
            <?php if (!Yii::app()->user->isGuest) { ?>
                <div class="user-profile border-top padding-horizontal-10 block">
                    <div class="inline-block">
                        <h5 class="no-margin"> Welcome </h5>
                        <h4 class="no-margin"> <?php echo ucfirst(Yii::app()->user->first_name).' '.ucfirst(Yii::app()->user->last_name); ?> </h4>
<!--
                        <a class="btn user-options sb_toggle">
                            <i class="fa fa-cog"></i>
                        </a>
-->
                    </div>
                </div>
            <?php } ?>
            <!-- start: MAIN NAVIGATION MENU -->
            <?= $this->renderPartial('application.views.layouts._nav', array('id' => 'nav')); ?>
            <?= $this->renderPartial('webroot.themes.' . Yii::app()->theme->name . '.views.layouts._sidebarLeft_modules'); ?>
            <!-- end: MAIN NAVIGATION MENU -->
        </div>
        <!-- end: SIDEBAR -->
    </div>
    <div class="slide-tools">
        <div class="col-xs-6 text-left no-padding">
            <a class="btn btn-sm status" href="#">
                Status <i class="fa fa-dot-circle-o text-green"></i> <span>Online</span>
            </a>
        </div>
        <?php if (!Yii::app()->user->isGuest) { ?>
        <div class="col-xs-6 text-right no-padding">
            <a class="btn btn-sm log-out text-right" href="/user/logout">
                <i class="fa fa-power-off"></i> Log Out
            </a>
        </div>
        <?php } ?>
    </div>
</nav>
<!-- end: PAGESLIDE LEFT -->
