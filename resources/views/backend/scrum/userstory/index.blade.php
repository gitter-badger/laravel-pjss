@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.scrum.userstories.management'))

@section ('styles')
{{ Html::style('vendor/dropzone/dropzone.min.css') }}
{{ Html::style('vendor/handsontable/pro/handsontable.full.min.css') }}
{{ Html::style("vendor/toastr/toastr.min.css") }}
<style>
    .modal .modal-body .tab-content {
	   margin: -20px -30px -30px -30px;
    }
    .modal .modal-footer .nav > li > a {
	   padding: 8px 15px;
    }
    
    .dz-preview {
	   display: none !important;
    }
    
    .sortable-list.ui-sortable li.ui-sortable-handle {
        padding-left: 30px;
    	background: url('/img/move-up-down.png') no-repeat 10px center;
    	background-size: 12px 35px;
    }
    .sortable-list.ui-sortable-disabled li.ui-sortable-handle {
        padding-left: 10px;
    	background-image: none;
    }
</style>
@stop

@section ('scripts')
{{ Html::script('vendor/toastr/toastr.min.js') }}
{{ Html::script('vendor/artTemplate/template.js') }}
{{ Html::script('vendor/dropzone/dropzone.min.js') }}
{{ Html::script('vendor/handsontable/pro/handsontable.full.min.js') }}
{{ Html::script('vendor/js-xlsx/xlsx.core.min.js') }}
{{ Html::script('vendor/jquery-ui/jquery-ui.min.js') }}
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

		var type_enum = {
    		'1': '功能性',
    		'2': '技术性'
		};

		template.helper('typeFormat', function (type) {
		    return type_enum[type];
		});

		template.helper('typeLabelFormat', function (type) {
		    var label;

		    switch(type){
    		    case 1:
    		    	label = 'primary';
    			    break;
    		    case 2:
    		    	label = 'default';
    			    break;
			    default:
			    	label = 'white';;
			    	break;
		    }

		    return label;
		});

		template.helper('priorityLabelFormat', function (priority) {
			var label;
			
		    if (priority > 80) {
		    	label = 'danger';
		    } else if (priority > 60) {
		    	label = 'warning';
		    } else if (priority > 40) {
		    	label = 'success';
		    } else if (priority > 20) {
		    	label = 'info';
		    } else {
		    	label = 'white';
		    }

		    return label;
		});

		/* private members */
		function render(data, method) {
			method = method || 'append';
			
			var html = template('tpl_userstory_list', data);
			$('#user_story_list')[method](html);
		}

		function renderExcel(data) {
			var sheet = template('tpl_sheet', data);
			var excel = template('tpl_excel', data);

			var $modal = $('#modal-excel-show');
			$modal.find('.modal-footer .nav').html(sheet);
			$modal.find('.modal-content .tab-content').html(excel);
		}

		/* events define */
		$$.on('edit.begin', function(e, item) {
			$("#user_story_list").sortable('enable');

			var $btn = $(item);
			$btn.toggleClass('hidden');
			$btn.next().toggleClass('hidden');
		}).on('edit.end', function(e, item) {
			$("#user_story_list").sortable('disable');

			var userStoryIDs = $('#user_story_list').sortable('toArray');

        	$.ajax({
            	type: 'POST',
            	url: '{{ route('admin.scrum.userstory.re_order') }}',
            	data: {
                	ids: userStoryIDs
            	},
            	headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				}
        	}).then(function(){
        		var $btn = $(item);
    			$btn.toggleClass('hidden');
    			$btn.prev().toggleClass('hidden');
    			
        		$$.trigger('refresh');
        	});
		}).on('move.exchange', function(e, item) {
			var $li = $(item).parents('li:first');
			
		}).on('move.up', function(e, item) {
			var $li = $(item).parents('li:first');
			var $prev = $li.prev();
			if ($prev.size() > 0) {
				$.ajax({
                	type: 'POST',
                	url: '{{ route('admin.scrum.userstory.exchange') }}',
                	data: {
                    	ids: [$li.attr('id'), $prev.attr('id')]
                	},
                	headers: {
    					'X-CSRF-TOKEN': '{{ csrf_token() }}'
    				}
            	}).then(function(){
            		$$.trigger('refresh');
            	});
			}
		}).on('move.down', function(e, item) {
			var $li = $(item).parents('li:first');
			var $next = $li.next();
			if ($next.size() > 0) {
				$.ajax({
                	type: 'POST',
                	url: '{{ route('admin.scrum.userstory.exchange') }}',
                	data: {
                    	ids: [$li.attr('id'), $next.attr('id')]
                	},
                	headers: {
    					'X-CSRF-TOKEN': '{{ csrf_token() }}'
    				}
            	}).then(function(){
            		$$.trigger('refresh');
            	});
			}
		}).on('delete', function(e, item) {
			var $li = $(item).parents('li:first');

			$.ajax({
            	type: 'DELETE',
            	url: '{{ route('admin.scrum.userstory.destroy', '') }}' + '/' + $li.attr('id'),
            	headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				}
        	}).then(function(){
        		$$.trigger('refresh');
        	});
		}).on('refresh', function(e){
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
			$$.trigger(eventName, e.target);
		});

		/* ctor */
		render({!! $user_stories !!});

		// Dropzone
    	(function(){
    		var dropzone_options = { 
    				url: '{{ route('admin.scrum.userstory.import_excel') }}',
    				maxFilesize: 2,
    				acceptedFiles: '.xls,.xlsx',
    				headers: {
    					'X-CSRF-TOKEN': '{{ csrf_token() }}'
    				},
    				accept: function(file, done) {
    					try {
    						throw new Error('暂时不显示预览');
    						$('#modal-excel-show').modal('show');
    
    	    				var reader = new FileReader();
    	    			    reader.onload = function(e) {
    	    			      var data = e.target.result;
    	    
    	    			      /* if binary string, read with type 'binary' */
    	    			      var workbook = XLSX.read(data, {type: 'binary'});
    	    
    	    			      console.info(workbook);
    	    			      renderExcel(workbook.SheetNames);
    	    			      $.each(workbook.Sheets, function(name, sheet){   			    	  
    	    			    	  var data = XLSX.utils.sheet_to_json(sheet);
    	    			    	  var hot = new Handsontable($('#excel-sheet-' + name + '-contrainer').get(0), {
    	  		                    data: data,
    	  		                    minSpareCols: 1,
    	  		                    minSpareRows: 1,
    	  		                    rowHeaders: true,
    	  		                    colHeaders: true,
    	  		                    contextMenu: true,
    	  		                    width: 838,
    	  		                    height: 400
    	  						});
    	    			      });
    	    			    };
    	    			    reader.readAsBinaryString(file);
    					} catch(ex) {
    						console.error(ex);
    						console.log('ECMAScript5 is not supported. change to ajax mode!');
    						done();
    					}
    				},
    				success: function(file, excelData, e) {
    					$.ajax({
    						url: '{{ route('admin.scrum.userstory.index') }}'
    					}).then(function(data){
    						toastr.success('文件' + file.name + '已导入！', '导入成功');
    						
    						render(data, 'html');
    					});
    				},
    				error: function(file, returnValue, xhr) {
    					toastr.error('文件' + file.name + '存在错误！', '导入失败');
    				}
    			};
			
    			$('body').dropzone(dropzone_options);
    			$('#import-excel').dropzone($.extend({ 
    				clickable: true
    			}, dropzone_options));
    	})();

    	// Sortable
    	$("#user_story_list").sortable({
            connectWith: ".connectList",
            disabled: true
        }).disableSelection();
	});
</script>
@stop

@section ('action')
<div class="btn-group">
  <a href="{{ route('admin.scrum.userstory.create') }}" class="btn btn-primary">新增</a>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right">
    <li>
    	<a href="#" id="import-excel">
    		导入Excel
    		<span class="pull-right"><i class="fa fa-upload"></i></span>
		</a>
	</li>
    <li role="separator" class="divider"></li>
    <li>
    	<a href="{{ route('admin.scrum.userstory.export_excel') }}">
    		导出Excel
    		<span class="pull-right"><i class="fa fa-download"></i></span>
		</a>
	</li>
  </ul>
</div>
<a href="#edit/begin" class="btn btn-primary">编辑</a>
<a href="#edit/end" class="btn btn-primary hidden">完成</a>
@stop

@section ('content')
<!-- modal-excel-show -->
<div class="modal fade" tabindex="-1" role="dialog"
	id="modal-excel-show">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">确认数据</h4>
			</div>
			<div class="modal-body">
                <div class="tab-content"></div>
			</div>
			<div class="modal-footer">
				<div class="pull-left">
					<ul class="nav nav-pills"></ul>
				</div>
			
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<a href="#upload/excel/data" class="btn btn-primary">导入</a>
			</div>
		</div>
	</div>
</div>

@include('backend.scrum.userstory.includes.list')

<!-- list -->
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
        		<div class="ibox-title">
        			<h5>用户故事</h5>
        			<div class="ibox-tools">
        				<i class="fa fa-hand-pointer-o"></i> 支持直接将Excel文件拖拽至本页面
        			</div>
        		</div>
                <div class="ibox-content">
                    <ul class="sortable-list connectList agile-list" id="user_story_list"></ul>
                </div>
            </div>
		</div>
	</div>
</div>

<!-- friendly links -->
{{ link_to('http://www.dropzonejs.com/', 'DropzoneJS', ['target' => '_blank']) }}
{{ link_to('https://github.com/SheetJS/js-xlsx', 'SheetJS', ['target' => '_blank']) }}
{{ link_to('http://handsontable.com/', 'handsontable', ['target' => '_blank']) }}
{{ link_to('http://jqueryui.com/', 'JqueryUI', ['target' => '_blank']) }}
@stop