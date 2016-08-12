@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.organization.project.management'))

@section ('styles')
	{{ Html::style("vendor/toastr/toastr.min.css") }}
	{{ Html::style("vendor/bootstrap-floating-labels/floating-labels.css") }}
	{{ Html::style("css/vendor.fix/bootstrap-floating-labels/floating-labels.css") }}
@endsection

@section ('scripts')
	{{ Html::script('vendor/toastr/toastr.min.js') }}
	{{ Html::script('vendor/bootstrap-floating-labels/floating-labels.js') }}
	{{ Html::script('vendor/artTemplate/template.js') }}
<script>
	$(function(){
		var $$ = $(this);

		template.helper('dateFormat', function (date, format) {
			date = new Date(date);

		    if (!format){
		    	return date.toLocaleDateString();
		    }

		    return date;
		});

		template.helper('toLabel', function (code) {
			code = parseInt(code, 10);
		
			var label;
		    switch(code) {
    		    case 0:
    		    	label = 'warning';
			    	break;
			    default:
			    	label = 'default';
			    	break;
		    }
		    return label;
		});

		function render(data, method) {
			method = method || 'append';
			
			var html = template('tpl_project_list', data);
			$('.project-list').find('table > tbody')[method](html);
		}

		function project_add(project, members) {
			return $.ajax({
				type: 'POST',
				url: '{{route('admin.organization.project.store')}}',
				data: $.extend({
					project: project,
					members: members
				}, {
					_token: $('[name="_token"]').val()
				})
			});
		}
		
		$$.on('sync.leangoo.project', function(e){
			var $form = $('#modal_sync_leangoo_project').find('form');
			var id = $form.find('[name="id"]').val();
			
			$.ajax({
				url: '/admin/sync/leangoo/project/' + id,
				data: {
					un: $form.find('[name="un"]').val(),
					pwd: $form.find('[name="pwd"]').val()
				}
			}).then(function(data){
				var project = data.project;
				var members = data.members;
				project.id = id;
				
				project_add(project, members).then(function(data, textStatus, jqXHR){
					project.members = members;
					// default
					project.complete_rate = 0;
					project.create_date = new Date().toString();
					// render
					render([project], 'prepend');

					toastr.success('项目' + id + '已同步', '同步成功');
				});
			}, function(jqXHR, textStatus, errorThrown){
				toastr.error(errorThrown, '同步失败');
			}); 
		});

		$(document).on('click', 'a[href^="#"]', function(e){
			e.preventDefault();

			var eventName = $(this).attr('href').substr(1).replace(/\//g, '.');
			$$.trigger(eventName);
		});

		render({!! $projects !!});
	});
</script>
@endsection

@section ('content')
{{csrf_field()}}

<div class="modal fade" tabindex="-1" role="dialog"
	id="modal_sync_leangoo_project">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">同步 Leangoo 项目</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group floating-label-form-group">
						<label for="leangoo_email">Leangoo 邮箱</label> <input type="email"
							class="form-control" id="leangoo_email" name="un"
							placeholder="邮箱" />
					</div>
					<div class="form-group floating-label-form-group">
						<label for="leangoo_pwd">Leangoo 密码</label> <input type="password"
							class="form-control" id="leangoo_pwd" name="pwd" placeholder="密码" />
					</div>
					<div class="form-group floating-label-form-group">
						<label for="leangoo_proj_id">Leangoo 项目编号</label> <input
							type="number" class="form-control" id="leangoo_proj_id" name="id"
							placeholder="项目编号" />
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<a href="#sync/leangoo/project" class="btn btn-primary">同步</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('backend.project.includes.list')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-title">
            <h5>所有项目</h5>
            <div class="ibox-tools">
                <a href="#" class="btn btn-primary btn-xs"
                	data-toggle="modal" data-target="#modal_sync_leangoo_project">同步项目</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row m-b-sm m-t-sm">
                <div class="col-md-1">
                    <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refresh</button>
                </div>
                <div class="col-md-11">
                    <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                </div>
            </div>

            <div class="project-list">
                <table class="table table-hover">
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
