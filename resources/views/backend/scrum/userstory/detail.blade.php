@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.scrum.userstories.management'))

@section ('styles')
	@parent
@stop

@section ('scripts')
	@parent
@stop

@section ('action')
	<a href="{{ url()->previous() }}" class="btn btn-primary">
		<i class="fa fa-arrow-left"></i> 返回
	</a>
@stop

@section ('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    	<div class="col-lg-12">
    		<div class="ibox">
    			<div class="ibox-title">
    				<h5>
    					{{ trans('menus.backend.scrum.userstories.detail') }}
    				</h5>
    				<div class="ibox-tools">
    				</div>
    			</div>
    			<div class="ibox-content">
                    <form class="form-horizontal">
                    	<div class="form-group">
                    		<label for="code" class="col-sm-2 control-label">故事编号</label>
                    		<div class="col-sm-6">
                    			<p class="form-control-static">{{ $user_story->code }}</p>
                    		</div>
                    		
                    		<label for="priority" class="col-sm-2 control-label">优先级</label>
                    		<div class="col-sm-2">
                    			<p class="form-control-static">{{ $user_story->priority }}</p>
                    		</div>
                    	</div>
                    	<div class="form-group">
                    		<label for="description" class="col-sm-2 control-label">用户故事</label>
                    		<div class="col-sm-6">
                    			<p class="form-control-static">{{ $user_story->description }}</p>
                    		</div>
                    		
                    		<label for="story_type" class="col-sm-2 control-label">故事类型</label>
                    		<div class="col-sm-2">
                    			<p class="form-control-static">{{ $user_story->story_type }}</p>
                    		</div>
                    	</div>
                    	<div class="hr-line-dashed"></div>
                    	<div class="form-group">
                    		<label for="acceptance_criteria" class="col-sm-2 control-label">验收标准</label>
                    		<div class="col-sm-10">
                    			@include('backend.scrum.userstory.acceptancecriteria.detail', [
                            		'acceptance_criterias' => $user_story->acceptance_criterias
                            	])
                    		</div>
                    	</div>
                    	
                    	<div class="hr-line-dashed"></div>
                    	<div class="form-group">
                    		<label for="lo_fi" class="col-sm-2 control-label">低保真</label>
                    		<div class="col-sm-10">
                    			@include('includes.components.file.download', [
                    				'id' => 'lo-fi',
                            		'files' => $user_story->lo_fi,
                            	])
                    		</div>
                    	</div>
                    	<div class="form-group">
                    		<label for="hi_fi" class="col-sm-2 control-label">高保真</label>
                    		<div class="col-sm-10">
                    			@include('includes.components.file.download', [
                    				'id' => 'hi-fi',
                            		'files' => $user_story->hi_fi,
                            	])
                    		</div>
                    	</div>
                    	<div class="form-group">
                    		<label for="attachments" class="col-sm-2 control-label">附件</label>
                    		<div class="col-sm-10">
                    			@include('includes.components.file.download', [
                    				'id' => 'attachments',
                            		'files' => $user_story->attachments,
                            	])
                    		</div>
                    	</div>
                    </form>
				</div>
    		</div>
    	</div>
    </div>
    @include('includes.components.comment.changyan', ['source' => 'USERSTORY_' . $user_story->id])
</div>
@stop