@extends ('frontend.layouts.inspinia')

@section ('title', trans('labels.frontend.scrum.backlogmeetings.management'))

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
			
			var html = template('tpl_backlogmeeting_list', data);
			$('.backlogmeeting-list').find('table > tbody')[method](html);
		}

		/* events define */
		$$.on('refresh', function(e){
			$.ajax({
				url: '{{route('admin.scrum.backlogmeeting.index')}}'
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
		render({!! $backlog_meetings !!});
	});
</script>
@stop

@section ('content')
@include('frontend.backlogmeeting.includes.list')

@stop