<script id="tpl_userstory_list" type="text/html">
    {{each $data as value i}}
        {{include 'tpl_userstory_list_item' value}}
    {{/each}}
</script>
<script id="tpl_userstory_list_item" type="text/html">
<li class="warning-element" id="{{id}}">
    {{name}}
    <div class="agile-detail">
        <a href="#" class="pull-right btn btn-xs btn-white">{{type}}</a>
        <i class="fa fa-clock-o"></i> {{create_date}}
    </div>
</li>
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