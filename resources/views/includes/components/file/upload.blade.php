@section ('styles')
@parent
{{ Html::style('vendor/blueimp-file-upload/css/jquery.fileupload.css') }}
{{ Html::style('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}
<style>
.bootstrap-tagsinput {
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
	display: table-cell;
	position: relative;
	z-index: 2;
	float: left;
	width: 100%;
	margin-bottom: 0;
	background-color: #FFFFFF;
	background-image: none;
	border: 1px solid #e5e6e7;
	border-radius: 1px;
	color: inherit;
	padding: 4px 12px 3px 12px;
	transition: border-color 0.15s ease-in-out 0s, 
	   box-shadow 0.15s ease-in-out 0s;
	font-size: 14px;
	box-shadow: none;
    min-height: 34px;
	line-height: 1.42857143;
	font-family: inherit;
	margin: 0;
	font: inherit;
	cursor: default;
}

.bootstrap-tagsinput.active {
	border-color: #1ab394 !important;
}

.bootstrap-tagsinput input {
	display: none;
}

.bootstrap-tagsinput .tag {
	line-height: 25px;
}

.input-group .input-group-btn .btn {
	height: calc(100% + 14px);
}
</style>
@stop

@section ('scripts')
@parent
{{ Html::script('vendor/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('vendor/blueimp-file-upload/js/jquery.iframe-transport.js') }}
{{ Html::script('vendor/blueimp-file-upload/js/jquery.fileupload.js') }}
{{ Html::script('vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}
<script>
$(function() {
	function render(files) {
		$.each(files, function (index, file) {
        	$('#{{ $id }}-tagsinput').tagsinput('add', {
	        	id: file.id,
	        	name: file.file_name
        	});
        });
	}
	
	$('#{{ $id }}').fileupload({
		url: '{{ route('admin.file.media.upload') }}',
		autoUpload: true,
		paramName: 'file',
	    add: function (e, data) {
	    	data.formData = {
    			'_token': '{{ csrf_token() }}'
	    	};
	        data.submit();
	    },
	    done: function (e, data) {
		    var files = JSON.parse(data.result);
		    @if (! $multiple)
	    	$('#{{ $id }}-tagsinput').tagsinput('removeAll');
	    	@endif
	        $.each(files, function (index, file) {
	        	$('#{{ $id }}-tagsinput').tagsinput('add', {
		        	id: file.model_id,
		        	name: file.file_name
	        	});
	        });
	    }
	});

	$('#{{ $id }}-folder-selector').on('change', function (e) {
		$('#{{ $id }}').fileupload('add', {
	        fileInput: $(this)
	    });
	});

	render({!! $values !!});
});

$('#{{ $id }}-tagsinput').tagsinput({
    itemValue: 'id',
    itemText: 'name',
    focusClass: 'active',
    itemRemoved: function(event) {
        console.info(event, event.item);
    }
});
</script>
@stop

<div class="input-group">
	<span class="input-group-addon"><i class="fa {{ $multiple ? 'fa-files-o' : 'fa-file-o' }}"></i></span>
    <input type="text" id="{{ $id }}-tagsinput" name="{{ $name }}" 
    	class="form-control" data-role="tagsinput"
    	aria-describedby="{{ $id }}-upload-addfile">
    <div class="input-group-btn">
        <button class="btn btn-default fileinput-button" id="{{ $id }}-upload-addfile"
        	title="添加文件">
            <i class="fa fa-plus"></i>
        	<input type="file" id="{{ $id }}" {{ $multiple ? 'multiple' : '' }}>
        </button>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
        	@if ($multiple)
            <li>
            	<a class="fileinput-button" title="添加文件夹">
                    <span>添加文件夹&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input type="file" id="{{ $id }}-folder-selector" multiple webkitdirectory>
                    <span class="badge badge-warning">alpha*</span>
                </a>
            </li>
            <li role="separator" class="divider"></li>
            @endif
            <li>
            	<a href="#" class="" title="管理文件">
                    <span>管理文件</span>
                </a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
            	<a type="submit" class="btn btn-primary start">
                    <span>Start upload</span>
                </a>
            </li>
            <li>
            	<a type="submit" class="btn btn-primary cancel">
                    <span>Cancel upload</span>
                </a>
            </li>
            <li>
            	<a type="submit" class="btn btn-primary delete">
                    <span>Delete</span>
                </a>
            </li>
        </ul>
	</div>
</div>
