<script id="tpl_files_list" type="text/html">
    {{each $data as value i}}
    <li id="{{value.id}}">
        <a href="/admin/file/media/{{value.id}}/download">
            <i class="fa {{value.type_ico}}"></i>
            {{value.file_name}}
            <span class="label">({{value.file_size | formatSize}})</span>
        </a>
    </li>
    {{/each}}
</script>