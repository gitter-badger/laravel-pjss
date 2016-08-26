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
	padding: 6px 12px;
	transition: border-color 0.15s ease-in-out 0s, 
	   box-shadow 0.15s ease-in-out 0s;
	font-size: 14px;
	box-shadow: none;
	height: 34px;
	line-height: 1.42857143;
	font-family: inherit;
	margin: 0;
	font: inherit;
}

.bootstrap-tagsinput.active {
	border-color: #1ab394 !important;
}
</style>
@stop

@section ('scripts')
@parent
{{ Html::script('vendor/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('vendor/blueimp-file-upload/js/jquery.fileupload.js') }}
{{ Html::script('vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}
<script>
$(function() {
	var $tags = $('#{{ $id }}-tagsinput');

	$('input[type="file"]').fileupload({
	    dataType: 'json',
	    add: function (e, data) {
	        console.info(data)
	        $.each(data.files, function(i, file) {
	        	$tags.tagsinput('add', {
		        	id: Math.random(),
		        	name: file.name,
		        	size: file.size,
		        	type: file.type
	        	});
	        });
	    },
	    done: function (e, data) {
	        $.each(data.result.files, function (index, file) {
	            $('<p/>').text(file.name).appendTo(document.body);
	        });
	    }
	});
});

$('input[data-role="tagsinput"]').tagsinput({
    itemValue: 'id',
    itemText: 'name',
    focusClass: 'active'
});
</script>
@stop

<div class="input-group">
    <input type="text" id="{{ $id }}-tagsinput" class="form-control" 
    	data-role="tagsinput" disabled
    	aria-describedby="{{ $id }}-upload-addfile">
    <div class="input-group-btn">
        <span class="btn btn-default fileinput-button" id="{{ $id }}-upload-addfile">
            <i class="fa fa-file-o"></i>
            <span>Add files...</span>
            <input type="file" id="{{ $id }}" name="{{ $name }}[]" multiple>
        </span>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
            	<a class="fileinput-button">
                    <i class="fa fa-folder-o"></i>
                    <span>Add folders...</span>
                    <input type="file" name="{{ $name }}[]" multiple webkitdirectory>
                </a>
            </li>
        </ul>
	</div>
</div>


<button type="submit" class="btn btn-primary start">
    <i class="fa fa-arrow-circle-o-up"></i>
    <span>Start upload</span>
</button>
<button type="reset" class="btn btn-warning cancel">
    <i class="fa fa-ban"></i>
    <span>Cancel upload</span>
</button>
<button type="button" class="btn btn-danger delete">
    <i class="fa fa-trash-o"></i>
    <span>Delete</span>
</button>
<input type="checkbox" class="toggle">
<!-- The global file processing state -->
<span class="fileupload-process"></span>