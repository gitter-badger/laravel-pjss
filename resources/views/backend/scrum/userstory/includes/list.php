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
    {{description}}
    <div class="agile-detail">
        <a href="#" class="pull-right btn btn-xs btn-{{story_type | typeLabelFormat}}">{{story_type | typeFormat}}</a>
        <i class="fa fa-clock-o"></i> {{created_at}}
    </div>
</li>
</script>