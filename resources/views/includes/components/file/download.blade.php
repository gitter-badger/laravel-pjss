@section ('styles')
@parent

@stop

@section ('scripts')
@parent
<script>
$(function() {
	var $$ = $(this);
	
	/* template helper */
	template.helper('formatSize', function (size) {
		var units = ['B', 'KB', 'M', 'G', 'T'];
		function toUnits(size, idx) {
			idx = idx || 0;
			
			if (size < 1000.0 || idx >= units.length) {
				return size.toFixed(1) + units[idx];
			}

			return toUnits(size / 1000, ++idx);
		}

	    return toUnits(parseFloat(size));
	});
	
	/* private members */
	function render(data, method) {
		method = method || 'append';
		
		var html = template('tpl_files_list', data);
		$('#{{ $id }}-files-list')[method](html);
	}
	
	render({!! $files !!});
});
</script>
@stop

@include('includes.components.file.includes.download-list')
<div class="form-control-static">
	<ul class="list-inline" id="{{ $id }}-files-list">
    </ul>
</div>