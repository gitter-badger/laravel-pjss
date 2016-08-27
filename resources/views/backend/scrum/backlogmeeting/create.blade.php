@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.scrum.backlogmeetings.management'))

@section ('styles')

@stop

@section ('scripts')

@stop
@section ('action')
<a href="{{ url()->previous() }}" class="btn btn-primary">
		<i class="fa fa-arrow-left"></i> 返回
	</a>
@stop
@section ('content')

@stop