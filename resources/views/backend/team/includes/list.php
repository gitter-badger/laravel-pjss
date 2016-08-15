<script id="tpl_team_list" type="text/html">
    {{each $data as value i}}
        {{include 'tpl_team_list_item' value}}
    {{/each}}
</script>
<script id="tpl_team_list_item" type="text/html">
<div class="col-lg-4">
<div class="ibox">
    <div class="ibox-title">
		<span class="label label-{{label_code}} pull-right">{{label}}</span>
		<h5>{{code}} - {{name}}</h5>
	</div>
	<div class="ibox-content">
        <div class="team-members">
            {{include 'tpl_member_list' members}}
        </div>
		<h4>Info about {{name}}</h4>
		<p>{{remarks}}</p>
		<div>
			<span>Status of current team:</span>
			<div class="stat-percent">{{complete_rate}}%</div>
			<div class="progress progress-mini">
				<div style="width: {{complete_rate}}%;" class="progress-bar"></div>
			</div>
		</div>
		<div class="row  m-t-sm">
			<div class="col-sm-4">
				<div class="font-bold">PROJECTS</div>
				{{projects_count}}
			</div>
			<div class="col-sm-4">
				<div class="font-bold">RANKING</div>
				{{ranking}}
			</div>
			<div class="col-sm-4 text-right">
				<div class="font-bold">BUDGET</div>
				{{bugget}} <i class="fa fa-level-up text-navy"></i>
			</div>
		</div>
	</div>
</div>
</div>
</script>
<script id="tpl_member_list" type="text/html">
{{each $data as member i}}
    {{include 'tpl_member_list_item' member}}
{{/each}}
</script>
<script id="tpl_member_list_item" type="text/html">
<a href="mailto:{{email}}" data-id="{{id}}">
    {{if head_img_status == 1}}
    <span class="avatar {{is_admin == 'Y' ? 'admin' : ''}}" title="{{nick_name}}">
        {{head_img_letter}}
    </span>
    {{else if head_img_status == 2}}
    <img alt="{{head_img_name}}" class="img-circle {{is_admin == 'Y' ? 'admin' : ''}}" 
        src="https://www.leangoo.com/kanban{{head_img_path}}" title="{{nick_name}}" />
    {{else}}
    {{/if}}
</a>
</script>