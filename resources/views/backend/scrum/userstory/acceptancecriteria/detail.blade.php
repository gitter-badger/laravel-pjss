@section ('styles')
@parent
<style>
.acceptancecriteria-list ul:empty {
	margin-bottom: 0;
}
</style>
@stop

@section ('scripts')
@parent
{{ Html::script('vendor/artTemplate/template.js') }}
<script>
	$(function(){
		var $$ = $(this);

		/* template helper */
		template.helper('formatHTML', function (text) {
		    return text.replace(/\r\n/g, '<br />');
		});
		
		/* private members */
		var add_i = 0;
		function render(data, method) {
			method = method || 'append';
			
			var html = template('tpl_acceptancecriteria_list', data);
			$('.acceptancecriteria-list').find('ol')[method](html);
		}

		/* events define */

		/* events emmit */
		$(document).on('click', 'a[href^="#"]', function(e){
			e.preventDefault();

			var eventName = $(this).attr('href').substr(1).replace(/\//g, '.');
			$$.trigger(eventName, e.target);
		});

		/* ctor */
		var json = {!! $acceptance_criterias !!};
		add_i = json.length;
		render(json);

		$('#acceptance_criteria').on('keydown', function(e) {
			var $this = $(this);
			
			if (e.ctrlKey && e.which == 13) {
				render([{
					_i: add_i++,
					condition: $.trim($this.val())
				}]);
				$this.val('');
			}
		});
	});
</script>
@stop

@include('backend.scrum.userstory.acceptancecriteria.includes.detail-list')
<div class="acceptancecriteria-list">
	<ol></ol>
</div>