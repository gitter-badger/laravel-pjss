<form class="form-horizontal" action="{{ $action }}" method="POST">
	{{ csrf_field() }}
	<input type="hidden" name="_method" value="{{ $method }}">
	
	<div class="form-group">
		<label for="code" class="col-sm-2 control-label">故事编号</label>
		<div class="col-sm-6">
			<input id="code" name="code" type="text" class="form-control"
				value="{{ $model->code }}">
		</div>
		
		<label for="priority" class="col-sm-2 control-label">优先级</label>
		<div class="col-sm-2">
			<input id="priority" name="priority" type="number" class="form-control"
				value="{{ $model->priority }}">
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">用户故事</label>
		<div class="col-sm-6">
			<input id="description" name="description" type="text" class="form-control"
				placeholder="作为一个&lt;角色&gt;, 我想要&lt;活动&gt;, 以便于&lt;商业价值&gt;"
				value="{{ $model->description }}">
		</div>
		
		<label for="story_type" class="col-sm-2 control-label">故事类型</label>
		<div class="col-sm-2">
			<select id="story_type" name="story_type" class="form-control">
				<option value="1" {{ $model->story_type == 1 ? 'selected="selected"': '' }}>功能性</option>
				<option value="2" {{ $model->story_type == 2 ? 'selected="selected"': '' }}>技术性</option>
			</select>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label for="acceptance_criteria" class="col-sm-2 control-label">验收标准</label>
		<div class="col-sm-10">
			<textarea id="acceptance_criteria" name="acceptance_criteria" rows="3" 
				class="form-control">{{ $model->acceptance_criteria }}</textarea>
			<span class="help-block m-b-none">按Enter添加一个验收标准，按Shift+Enter换行。</span>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label for="lo-fi" class="col-sm-2 control-label">低保真</label>
		<div class="col-sm-10">
			<input id="lo-fi" name="lo-fi" type="file" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label for="hi-fi" class="col-sm-2 control-label">高保真</label>
		<div class="col-sm-10">
			<input id="hi-fi" name="hi-fi" type="file" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label for="attachments" class="col-sm-2 control-label">附件</label>
		<div class="col-sm-10">
			<input id="attachments" name="attachments" type="file" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4 col-sm-offset-2">
			<a class="btn btn-white" href="{{ route('admin.scrum.userstory.index') }}">{{ trans('buttons.general.cancel') }}</a>
			<button class="btn btn-primary" type="submit">{{ trans('buttons.general.save') }}</button>
		</div>
	</div>
</form>