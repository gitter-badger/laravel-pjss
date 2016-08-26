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
    					{{ trans('menus.backend.scrum.userstories.create') }}
    				</h5>
    				<div class="ibox-tools">
    				</div>
    			</div>
    			<div class="ibox-content">
    				@include('backend.scrum.userstory.includes.form', [
    					'method' => 'POST', 
    					'action' => route('admin.scrum.userstory.store'),
    					'model' => $user_story,
					])
    			</div>
    		</div>
    	</div>
    </div>
</div>
@stop
