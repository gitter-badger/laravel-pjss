@extends ('frontend.layouts.inspinia')

@section ('title', trans('labels.frontend.scrum.meetings.management'))

@section ('styles')

@stop

@section ('scripts')
{{ Html::script('vendor/artTemplate/template.js') }}
<script>
	$(function(){
		var $$ = $(this);

		/* template helper */
		template.helper('dateFormat', function (date, format) {
			date = new Date(date);

		    if (!format){
		    	return date.toLocaleDateString();
		    }

		    return date;
		});

		/* private members */
		function render(data, method) {
			method = method || 'append';
			
			var html = template('tpl_meeting_list', data);
			$('.meeting-list').find('table > tbody')[method](html);
		}

		/* events define */
		$$.on('refresh', function(e){
			$.ajax({
				url: '{{route('admin.scrum.meeting.index')}}'
			}).then(function(data){
				render(data, 'html');
			});
		});

		/* events emmit */
		$(document).on('click', 'a[href^="#"]', function(e){
			e.preventDefault();

			var eventName = $(this).attr('href').substr(1).replace(/\//g, '.');
			$$.trigger(eventName);
		});

		/* ctor */
		render({!! $meetings !!});
	});
</script>
@stop

@section ('content')
@include('frontend.meeting.includes.list')

@stop