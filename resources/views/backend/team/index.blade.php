@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.organization.team.management'))

@section ('action')
    <a href="#" class="btn btn-primary">新建</a>
@stop

@section ('styles')
<style>
    .team-members span.avatar {
    	display: inline-block;
        width: 32px;
    	height: 32px;
    	border-radius: 50%;
        background: #ccc;
    	vertical-align: middle;
    	font-size: 12px;
        font-weight: 700;
        line-height: 32px;
        overflow: hidden;
        text-align: center;
    	color: #676a6c;
    }
    
    .team-members span.admin {
        background: #ccc url('/img/crown.png') no-repeat center 0;
    	background-size: 40%;
    }
</style>
@stop

@section ('scripts')
{{ Html::script('vendor/artTemplate/template.js') }}
<script>
	$(function(){
		var $$ = $(this);

		/* private members */
		function render(data, method) {
			method = method || 'append';
			
			var html = template('tpl_team_list', data);
			$('.team-list').find('.row')[method](html);
		}

		function team_add(team, members) {
			return $.ajax({
				type: 'POST',
				url: '{{route('admin.organization.team.store')}}',
				data: $.extend({
					team: team,
					members: members
				}, {
					_token: $('[name="_token"]').val()
				})
			});
		}

		/* events define */
		$$.on('create', function(e){
			project_search($('#searcher').val());
		});

		/* events emmit */
		$(document).on('click', 'a[href^="#"]', function(e){
			e.preventDefault();

			var eventName = $(this).attr('href').substr(1).replace(/\//g, '.');
			$$.trigger(eventName);
		});

		/* ctor */
		render({!! $teams !!});
		render([{},{},{},{}]);
	});
</script>
@stop

@section ('content')
<!-- csrf -->
{{csrf_field()}}

@include('backend.team.includes.list')
<div class="wrapper wrapper-content animated fadeInRight team-list">
	<div class="row">
	</div>
</div>
@stop