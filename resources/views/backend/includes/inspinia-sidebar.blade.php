<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<span>
						<img alt="image" class="img-circle" src="{{ access()->user()->picture }}" />
					</span>
					<a data-toggle="dropdown" class="dropdown-toggle"
						href="empty_page.html#">
						<span class="clear">
							<span class="block m-t-xs">
								<strong class="font-bold">{{ access()->user()->name }}</strong>
							</span>
							<span class="text-muted text-xs block">
								{{ implode(", ", access()->user()->roles->lists('name')->toArray()) }}
								<b class="caret"></b>
							</span>
						</span>
					</a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a href="profile.html">Profile</a></li>
						<li><a href="contacts.html">Contacts</a></li>
						<li><a href="mailbox.html">Mailbox</a></li>
						<li class="divider"></li>
						<li><a href="login.html">Logout</a></li>
					</ul>
				</div>
				<div class="logo-element">{{ app_name() }}</div>
			</li>
			<li class="{{ Active::pattern('admin/dashboard') }}">
                {{ link_to_route('admin.dashboard', trans('menus.backend.sidebar.dashboard')) }}
            </li>
            <li class="{{ Active::pattern('admin/organization/*') }}">
            	<a href="#">
            		<i class="fa fa-sitemap"></i>
            		<span class="nav-label">{{ trans('menus.backend.sidebar.organization.index') }}</span>
            		<span class="fa arrow"></span>
        		</a>
                <ul class="nav nav-second-level collapse">
					<li class="{{ Active::pattern('admin/organization/team') }}">
						{{ link_to_route('admin.organization.team.index', trans('menus.backend.sidebar.organization.team')) }}
					</li>
				</ul>
            </li>
		</ul>
	</div>
</nav>