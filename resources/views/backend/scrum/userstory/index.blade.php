@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.scrum.userstories.management'))

@section ('styles')
{{ Html::style('vendor/dropzone/dropzone.min.css') }}
@endsection

@section ('scripts')
{{ Html::script('vendor/artTemplate/template.js') }}
{{ Html::script('vendor/dropzone/dropzone.min.js') }}
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
			
			var html = template('tpl_userstory_list', data);
			$('.userstory-list').find('table > tbody')[method](html);
		}

		/* events define */
		$$.on('refresh', function(e){
			$.ajax({
				url: '{{route('admin.scrum.userstory.index')}}'
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
		render({!! $user_stories !!});

		$('body').dropzone({ 
			url: '{{ route('admin.scrum.userstory.import_excel') }}',
			maxFilesize: 2,
			acceptedFiles: '.xls,.xlsx',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			accept: function(file, done) {
				done();
			}
		});
	});
</script>
@endsection

@section ('action')
<div class="btn-group">
  <a class="btn btn-primary">新增</a>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right">
    <li>
    	<a href="#">
    		导入Excel
    		<span class="pull-right"><i class="fa fa-upload"></i></span>
		</a>
	</li>
    <li role="separator" class="divider"></li>
    <li>
    	<a href="#">
    		导出Excel
    		<span class="pull-right"><i class="fa fa-download"></i></span>
		</a>
	</li>
  </ul>
</div>
@endsection

@section ('content')
{{ csrf_field() }}

@include('backend.scrum.userstory.includes.list')

<!-- list -->
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="ibox">
		<div class="ibox-title">
			<h5>用户故事</h5>
			<div class="ibox-tools">
				
			</div>
		</div>
        <div class="ibox-content">
            <ul class="sortable-list connectList agile-list ui-sortable" id="user_story">
            </ul>
        </div>
    </div>
</div>

<!-- friendly links -->
{{ link_to('http://www.dropzonejs.com/', 'DropzoneJS', ['target' => '_blank']) }}
@endsection
