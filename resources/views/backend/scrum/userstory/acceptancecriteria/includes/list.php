<script id="tpl_acceptancecriteria_list" type="text/html">
    {{each $data as value i}}
    <li class="list-group-item" id="{{value.id}}">
        <input type="hidden" name="acceptance_criteria[{{value._i || i}}][id]" value="{{value.id}}">
        <input type="hidden" name="acceptance_criteria[{{value._i || i}}][condition]" value="{{value.condition}}">
        <div class="pull-right">
            <a class="btn btn-link btn-xs" href="#acceptancecriteria/delete">
                <i class="fa fa-trash-o"></i>
            </a>
        </div>
        {{value.condition}}
    </li>
    {{/each}}
</script>