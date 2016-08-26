@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.organization.project.management'))

@section ('styles')
{{ Html::style("vendor/toastr/toastr.min.css") }}
{{ Html::style("vendor/bootstrap-floating-labels/floating-labels.css") }}
{{ Html::style("css/vendor.fix/bootstrap-floating-labels/floating-labels.css") }}
<style>
    .project-people .user_name {
	   font-size: 0;
    }
    .project-people span.avatar {
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
    
    .project-people span.admin {
        background: #ccc url('/img/crown.png') no-repeat center 0;
    	background-size: 40%;
    }
</style>
@stop

@section ('scripts')
{{ Html::script('vendor/toastr/toastr.min.js') }}
{{ Html::script('vendor/bootstrap-floating-labels/floating-labels.js') }}
{{ Html::script('vendor/artTemplate/template.js') }}
{{ Html::script('vendor/list.js/list.min.js') }}
{{ Html::script('vendor/list.js/plugin/list.fuzzysearch.min.js') }}
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
		var searcher;

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

		function project_search(keyword) {
			searcher.search(keyword);
		}

		/* events define */
		$$.on('sync.leangoo.project', function(e){
			var $modal = $('#modal_sync_leangoo_project');
			var $form = $modal.find('form');
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
					$modal.modal('hide');
				});
			}, function(jqXHR, textStatus, errorThrown){
				toastr.error(errorThrown, '同步失败');
			}); 
		}).on('refresh', function(e){
			$.ajax({
				url: '{{route('admin.organization.project.index')}}'
			}).then(function(data){
				toastr.success('', 'Refreshed');
				render(data, 'html');
			});
		}).on('search', function(e){
			project_search($('#searcher').val());
		});

		/* events emmit */
		$(document).on('click', 'a[href^="#"]', function(e){
			e.preventDefault();

			var eventName = $(this).attr('href').substr(1).replace(/\//g, '.');
			$$.trigger(eventName);
		});

		/* ctor */
		render({!! $projects !!});
		searcher = new List('project-items', { 
            valueNames: ['name', 'user_name_0'
                         , 'user_name_1', 'user_name_2', 'user_name_3', 'user_name_4', 'user_name_5'
                         , 'user_name_6', 'user_name_7', 'user_name_8', 'user_name_9', 'user_name_10'
                         , 'user_name_11', 'user_name_12', 'user_name_13', 'user_name_14', 'user_name_15'
                         , 'user_name_16', 'user_name_17', 'user_name_18', 'user_name_19', 'user_name_20'], 
            plugins: [ ListFuzzySearch() ]
		});
	});
</script>
@stop

@section ('content')
<!-- csrf -->
{{csrf_field()}}

<!-- modal_sync_leangoo_project -->
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
	</div>
</div>

@include('backend.project.includes.list')

<!-- list -->
<div class="wrapper wrapper-content animated fadeInUp" id="project-items">
	<div class="ibox">
		<div class="ibox-title">
			<h5>所有项目</h5>
			<div class="ibox-tools">
				<a href="#" class="btn btn-primary btn-xs" data-toggle="modal"
					data-target="#modal_sync_leangoo_project">同步项目</a>
			</div>
		</div>
		<div class="ibox-content">
			<div class="row m-b-sm m-t-sm">
				<div class="col-md-1">
					<a href="#refresh" id="loading-example-btn"
						class="btn btn-white btn-sm">
						<i class="fa fa-refresh"></i> 刷新
					</a>
				</div>
				<div class="col-md-11">
					<div class="input-group">
						<input type="text" id="searcher" placeholder="请输入项目名称/成员名称" 
							class="input-sm form-control search">
						<span class="input-group-btn">
							<a href="#search" class="btn btn-sm btn-primary">搜索</a>
						</span>
					</div>
				</div>
			</div>

			<div class="project-list">
				<table class="table table-hover">
					<tbody class="list">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop