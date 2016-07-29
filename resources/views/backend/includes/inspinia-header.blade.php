<?php 
    $envelope_num = 16;
    $bell_num = 8;
?>
<div class="row border-bottom">
	<nav class="navbar navbar-static-top  " role="navigation"
		style="margin-bottom: 0">
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-primary "
				href="#"><i class="fa fa-bars"></i> </a>
			<form role="search" class="navbar-form-custom"
				action="search_results.html">
				<div class="form-group">
					<input type="text" placeholder="Search for something..."
						class="form-control" name="top-search" id="top-search">
				</div>
			</form>
		</div>
		<ul class="nav navbar-top-links navbar-right">
			<li>
				<span class="m-r-sm text-muted welcome-message">Welcome to {{ app_name() }}</span>
			</li>
			@if (config('locale.status') && count(config('locale.languages')) > 1)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                	{{ trans('menus.language-picker.language') }}
                	<span class="caret"></span>
            	</a>
                @include('includes.partials.lang')
            </li>
        	@endif
			<li class="dropdown">
				<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
					<i class="fa fa-envelope"></i>
					<span class="label label-warning">{{ $envelope_num }}</span>
				</a>
				<ul class="dropdown-menu dropdown-messages">
					<li>
						<div class="dropdown-messages-box">
							<a href="profile.html" class="pull-left"> <img alt="image"
								class="img-circle" src="#">
							</a>
							<div class="media-body">
								{{ trans_choice('strings.backend.general.you_have.messages', 0, ['number' => $envelope_num]) }}
								<small class="pull-right">46h ago</small> <strong>Mike Loreipsum</strong>
								started following <strong>Monica Smith</strong>. <br> <small
									class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
							</div>
						</div>
					</li>
					<li class="divider"></li>
					<li>
						<div class="text-center link-block">
							<a href="mailbox.html">
								<i class="fa fa-envelope"></i>
								<strong>{{ trans('strings.backend.general.see_all.messages') }}</strong>
							</a>
						</div>
					</li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
					<i class="fa fa-bell"></i>
					<span class="label label-primary">{{ $envelope_num }}</span>
				</a>
				<ul class="dropdown-menu dropdown-alerts">
					<li><a href="mailbox.html">
							<div>
								<i class="fa fa-envelope fa-fw"></i> You have 16 messages <span
									class="pull-right text-muted small">4 minutes ago</span>
							</div>
					</a></li>
					<li class="divider"></li>
					<li><a href="profile.html">
							<div>
								<i class="fa fa-twitter fa-fw"></i> 3 New Followers <span
									class="pull-right text-muted small">12 minutes ago</span>
							</div>
					</a></li>
					<li class="divider"></li>
					<li><a href="grid_options.html">
							<div>
								<i class="fa fa-upload fa-fw"></i> Server Rebooted <span
									class="pull-right text-muted small">4 minutes ago</span>
							</div>
					</a></li>
					<li class="divider"></li>
					<li>
						<div class="text-center link-block">
							<a href="notifications.html">
    							<strong>{{ trans('strings.backend.general.see_all.notifications') }}</strong>
    							<i class="fa fa-angle-right"></i>
							</a>
						</div>
					</li>
				</ul></li>


			<li>
				<a href="{{ URL::route('auth.logout') }}">
					<i class="fa fa-sign-out"></i>
					{{ trans('navs.general.logout') }}
				</a>
			</li>
		</ul>
	</nav>
</div>
