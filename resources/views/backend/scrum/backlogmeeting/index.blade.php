@extends ('backend.layouts.inspinia')

@section ('title', trans('labels.backend.scrum.backlogmeetings.management'))

@section ('styles')
<style>

</style>
@stop

@section ('scripts')
{{ Html::script('vendor/artTemplate/template.js') }}
<script>
	
</script>
@stop
@section('action')
<div class="btn-group">
  <a href="{{ route('admin.scrum.backlogmeeting.create') }}" class="btn btn-primary" ><i class="fa fa-plus"></i> 新增</a>
</div>
@stop
@section ('content')

@stop