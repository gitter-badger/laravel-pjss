<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<span>
						<img alt="image" class="img-circle" src="#{{ access()->user()->picture }}" />
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
				<div class="logo-element">PJSS+</div>
			</li>
			<li class="{{ Active::pattern('admin/dashboard') }}">
				<a href="{{ route('admin.dashboard') }}">
            		<i class="fa fa-dashboard"></i>
            		<span class="nav-label">{{ trans('menus.backend.sidebar.dashboard') }}</span>
        		</a>
            </li>
            <li class="{{ Active::pattern('admin/organization/*') }}">
            	<a href="#">
            		<i class="fa fa-sitemap"></i>
            		<span class="nav-label">{{ trans('menus.backend.sidebar.organization.index') }}</span>
            		<span class="fa arrow"></span>
        		</a>
                <ul class="nav nav-second-level collapse">
                	<li class="{{ Active::pattern('admin/organization/project') }}">
						{{ link_to_route('admin.organization.project.index', trans('menus.backend.sidebar.organization.project')) }}
					</li>
					<li class="{{ Active::pattern('admin/organization/team') }}">
						{{ link_to_route('admin.organization.team.index', trans('menus.backend.sidebar.organization.team')) }}
					</li>
				</ul>
            </li>
            <li class="{{ Active::pattern('admin/scrum/*') }}">
            	<a href="#">
            		<i class="fa fa-cubes"></i>
            		<span class="nav-label">{{ trans('menus.backend.sidebar.scrum.index') }}</span>
            		<span class="fa arrow"></span>
        		</a>
                <ul class="nav nav-second-level collapse">
                	<li class="{{ Active::pattern('admin/organization/project') }}">
						{{ link_to_route('admin.scrum.userstory.index', trans('menus.backend.sidebar.scrum.userstory')) }}
					</li>
				</ul>
            </li>
            
            <li class="">
            	<a href="#">
            		<i class="fa fa-external-link"></i>
            		<span class="nav-label">Friend Links</span>
            		<span class="fa arrow"></span>
        		</a>
                <ul class="nav nav-second-level collapse">
					<li class="">
						<a href="#">
                    		<span class="nav-label">PHP性能监控</span>
                    		<span class="fa arrow"></span>
                		</a>
                        <ul class="nav nav-third-level">
        					<li class="">
                                {{ link_to('//user.oneapm.com/pages/v2/home', 'OneAPM', ['target' => '_blank']) }}
                            </li>
        				</ul>
					</li>
					<li class="">
						<a href="#">
                    		<span class="nav-label">搜索</span>
                    		<span class="fa arrow"></span>
                		</a>
                        <ul class="nav nav-third-level">
                            <li class="">
                                {{ link_to('https://www.algolia.com/dashboard', 'Algolia', ['target' => '_blank']) }}
                            </li>
        				</ul>
					</li>
					<li class="">
						<a href="#">
                    		<span class="nav-label">DBaaS</span>
                    		<span class="fa arrow"></span>
                		</a>
                        <ul class="nav nav-third-level">
                            <li class="">
                                {{ link_to('https://www.bdp.cn/home.html', 'BDP', ['target' => '_blank']) }}
                            </li>
        				</ul>
					</li>
				</ul>
            </li>
		</ul>
	</div>
</nav>