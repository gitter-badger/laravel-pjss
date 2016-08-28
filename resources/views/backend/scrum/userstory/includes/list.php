<script id="tpl_excel" type="text/html">
    {{each $data as value i}}
        <div id="sheet-{{value}}" class="tab-pane {{i == 0 ? 'active' : ''}}">
            <div class="panel-body">
                <div id="excel-sheet-{{value}}-contrainer"></div>
            </div>
        </div>
    {{/each}}
</script>
<script id="tpl_sheet" type="text/html">
    {{each $data as value i}}
        <li class="{{i == 0 ? 'active' : ''}}"><a data-toggle="tab" href="#sheet-{{value}}"> {{value}}</a></li>
    {{/each}}
</script>

<script id="tpl_userstory_list" type="text/html">
    {{each $data as value i}}
        {{include 'tpl_userstory_list_item' value}}
    {{/each}}
</script>
<script id="tpl_userstory_list_item" type="text/html">
<li class="{{priority | priorityLabelFormat}}-element" id="{{id}}">
    <div class="pull-right">
        <div class="btn-group btn-group-xs" role="group">
            <!--a href="#move/exchange" class="btn btn-link" title="交换">
                <i class="fa fa-exchange"></i>
            </a-->
            <a href="#move/up" class="btn btn-link" title="上移">
                <i class="fa fa-long-arrow-up"></i>
            </a>
            <a href="#move/down" class="btn btn-link" title="下移">
                <i class="fa fa-long-arrow-down"></i>
            </a>
        </div>
        <div class="btn-group btn-group-xs" role="group">
            <a href="/admin/scrum/userstory/{{id}}/edit" class="btn btn-link" title="编辑"><i class="fa fa-edit"></i></a>
            <a href="#delete" class="btn btn-link" title="删除"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
    {{description}}
    <div class="agile-detail">
        <a href="#" class="pull-right btn btn-xs btn-{{story_type | typeLabelFormat}}">{{story_type | typeFormat}}</a>
        <i class="fa fa-clock-o"></i> {{created_at}}
    </div>
</li>
</script>