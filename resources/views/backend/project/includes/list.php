<script id="tpl_project_list" type="text/html">
    {{each $data as value i}}
        {{include 'tpl_project_list_item' value}}
    {{/each}}
</script>
<script id="tpl_project_list_item" type="text/html">
<tr data-item="{{#$data}}">
    <td class="project-status">
        <span class="label label-default">Leangoo</span>
    </td>
    <td class="project-title">
        <a href="#" class="name">{{name}}</a>
        <br/>
        <small>Created {{create_date | dateFormat}}</small>
    </td>
    <td class="project-completion">
        <small>Completion with: {{complete_rate}}%</small>
        <div class="progress progress-mini">
            <div style="width: {{complete_rate}}%;" class="progress-bar"></div>
        </div>
    </td>
    <td class="project-people">
        {{include 'tpl_member_list' members}}
    </td>
    <td class="project-actions">
        <a href="https://www.leangoo.com/kanban/project/go/{{id}}" class="btn btn-white btn-sm" target="_blank">
            <i class="fa fa-external-link"></i> View
        </a>
    </td>
</tr>
</script>
<script id="tpl_member_list" type="text/html">
    {{each $data as member i}}
        {{include 'tpl_member_list_item' member}}
        <span class="user_name user_name_{{i}}">{{member.nick_name}}</span>
    {{/each}}
</script>
<script id="tpl_member_list_item" type="text/html">
    <a href="mailto:{{email}}" data-id="{{id}}">
        {{if head_img_status == 1}}
        <span class="avatar" title="{{nick_name}}">{{head_img_letter}}</span>
        {{else if head_img_status == 2}}
        <img alt="{{head_img_name}}" 
            class="img-circle {{is_admin == 'Y' ? 'admin' : ''}}" 
            src="https://www.leangoo.com/kanban{{head_img_path}}" title="{{nick_name}}" />
        {{else}}
        {{/if}}
    </a>
</script>

<style>
    .project-people .user_name {
	   font-size: 0;
    }
    .project-people span.avatar {
    	display: inline-block;
        width: 32px;
    	height: 32px;
    	border-radius: 50%;
        background: #ccc;
    	vertical-align: middle;
    	font-size: 12px;
        font-weight: 700;
        line-height: 32px;
        overflow: hidden;
        text-align: center;
    	color: #676a6c;
    }
</style>