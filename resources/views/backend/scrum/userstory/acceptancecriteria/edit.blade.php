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
	artTemplate = template; //artTemplate和畅言有冲突
	$(function(){
		var $$ = $(this);

		/* template helper */
		template.helper('formatHTML', function (text) {
		    return text.replace(/\n/g, '<br />');
		});
		
		/* private members */
		var add_i = 0;
		function render(data, method) {
			method = method || 'append';
			
			var html = artTemplate('tpl_acceptancecriteria_list', data);
			$('.acceptancecriteria-list').find('ul')[method](html);
		}

		/* events define */
		$$.on('acceptancecriteria.delete', function(e, item) {
			var $i = $(item);
			var $li = $i.parent().parent().parent();
			if ($li.parent().children().size() == 1) {
				$li.parent().empty();
			} else {
				$li.remove();
			}
		});

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

@include('backend.scrum.userstory.acceptancecriteria.includes.edit-list')
<div class="acceptancecriteria-list">
	<ul class="list-group"></ul>
</div>
<textarea id="acceptance_criteria" rows="3" class="form-control"></textarea>
<span class="help-block m-b-none">按Enter换行，按Ctrl+Enter添加一个验收标准。</span>