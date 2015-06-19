<div class="toolbar row">
<?php if(isset($this->title)){ ?>
	<div class="col-xs-6">
		<div class="page-header">
			<h1><?= $this->title ?> <?php if(isset($this->subTitle)){ ?><small><?= $this->subTitle ?></small> <? } ?></h1>
		</div>
	</div>
<?php } ?>
	<div class="col-xs-6 pull-right">
		<a class="back-subviews" href="#">
			<i class="fa fa-chevron-left"></i> BACK
		</a>
		<a class="close-subviews" href="#" style="display: none; opacity: 0; left: 20px;">
			<i class="fa fa-times"></i> CLOSE
		</a>
		<div class="toolbar-tools pull-right" style="opacity: 1; left: 0px; display: block;">
			<!-- start: TOP NAVIGATION MENU -->
			<ul class="nav navbar-right">
				<!-- start: TO-DO DROPDOWN -->
				<li class="dropdown">
					<a href="#" data-close-others="true" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
						<i class="fa fa-plus"></i> SUBVIEW
					</a>
					<ul class="dropdown-menu dropdown-light dropdown-subview" style="display: none;">
						<li class="dropdown-header">Notes</li>
						<li>
							<a class="new-note" href="#newNote"><span class="fa-stack"> <i class="fa fa-file-text-o fa-stack-1x fa-lg"></i> <i class="fa fa-plus fa-stack-1x stack-right-bottom text-danger"></i> </span> Add new note</a>
						</li>
						<li>
							<a class="read-all-notes" href="#readNote"><span class="fa-stack"> <i class="fa fa-file-text-o fa-stack-1x fa-lg"></i> <i class="fa fa-share fa-stack-1x stack-right-bottom text-danger"></i> </span> Read all notes</a>
						</li>
						<li class="dropdown-header">Calendar</li>
						<li>
							<a class="new-event" href="#newEvent"><span class="fa-stack"> <i class="fa fa-calendar-o fa-stack-1x fa-lg"></i> <i class="fa fa-plus fa-stack-1x stack-right-bottom text-danger"></i> </span> Add new event</a>
						</li>
						<li>
							<a class="show-calendar" href="#showCalendar"><span class="fa-stack"> <i class="fa fa-calendar-o fa-stack-1x fa-lg"></i> <i class="fa fa-share fa-stack-1x stack-right-bottom text-danger"></i> </span> Show calendar</a>
						</li>
						<li class="dropdown-header">Contributors</li>
						<li>
							<a class="new-contributor" href="#newContributor"><span class="fa-stack"> <i class="fa fa-user fa-stack-1x fa-lg"></i> <i class="fa fa-plus fa-stack-1x stack-right-bottom text-danger"></i> </span> Add new contributor</a>
						</li>
						<li>
							<a class="show-contributors" href="#showContributors"><span class="fa-stack"> <i class="fa fa-user fa-stack-1x fa-lg"></i> <i class="fa fa-share fa-stack-1x stack-right-bottom text-danger"></i> </span> Show all contributor</a>
						</li>
					</ul>
				</li>
<!--
				<li class="dropdown">
					<a href="#" data-close-others="true" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
						<span class="messages-count badge badge-default hide">3</span> <i class="fa fa-envelope"></i> MESSAGES
					</a>
					<ul class="dropdown-menu dropdown-light dropdown-messages" style="display: none;">
						<li>
							<span class="dropdown-header"> You have 9 messages</span>
						</li>
						<li>
							<div class="drop-down-wrapper ps-container">
								<ul>
									<li class="unread">
										<a class="unread" href="javascript:;">
											<div class="clearfix">
												<div class="thread-image">
													<img alt="" src="./assets/images/avatar-2.jpg">
												</div>
												<div class="thread-content">
													<span class="author">Nicole Bell</span>
													<span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
													<span class="time"> Just Now</span>
												</div>
											</div>
										</a>
									</li>
									<li>
										<a class="unread" href="javascript:;">
											<div class="clearfix">
												<div class="thread-image">
													<img alt="" src="./assets/images/avatar-3.jpg">
												</div>
												<div class="thread-content">
													<span class="author">Steven Thompson</span>
													<span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
													<span class="time">8 hrs</span>
												</div>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:;">
											<div class="clearfix">
												<div class="thread-image">
													<img alt="" src="./assets/images/avatar-5.jpg">
												</div>
												<div class="thread-content">
													<span class="author">Kenneth Ross</span>
													<span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
													<span class="time">14 hrs</span>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="view-all">
							<a href="pages_messages.html">
								See All
							</a>
						</li>
					</ul>
				</li>
-->
				<li class="menu-search">
					<a href="#">
						<i class="fa fa-search"></i> SEARCH
					</a>
					<!-- start: SEARCH POPOVER -->
					<div class="popover bottom search-box transition-all" style="opacity: 0; display: none; transform: scale(0.9);">
						<div class="arrow"></div>
						<div class="popover-content">
							<!-- start: SEARCH FORM -->
							<form action="#" id="searchform" class="">
								<div class="input-group">
									<input type="text" placeholder="Search" class="form-control">
									<span class="input-group-btn">
										<button type="button" class="btn btn-main-color btn-squared">
											<i class="fa fa-search"></i>
										</button> </span>
								</div>
							</form>
							<!-- end: SEARCH FORM -->
						</div>
					</div>
					<!-- end: SEARCH POPOVER -->
				</li>
			</ul>
			<!-- end: TOP NAVIGATION MENU -->
		</div>
	</div>
</div>