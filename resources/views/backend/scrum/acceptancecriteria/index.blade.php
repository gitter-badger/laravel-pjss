@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.scrum.acceptancecriterias.management'))

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
			
			var html = template('tpl_acceptancecriteria_list', data);
			$('.acceptancecriteria-list').find('table > tbody')[method](html);
		}

		/* events define */
		$$.on('refresh', function(e){
			$.ajax({
				url: '{{route('admin.scrum.acceptancecriteria.index')}}'
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
		render({!! $acceptance_criterias !!});
	});
</script>
@stop

@section ('content')
@include('backend.acceptancecriteria.includes.list')

@stop