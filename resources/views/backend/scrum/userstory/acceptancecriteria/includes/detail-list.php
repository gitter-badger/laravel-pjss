<script id="tpl_acceptancecriteria_list" type="text/html">
    {{each $data as value i}}
    <li class="" id="{{value.id}}">
        {{#value.condition | formatHTML}}
    </li>
    {{/each}}
</script>