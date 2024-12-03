<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="control-label">{{ __('Image 1') }}</label>
            {{ Form::mediaImage('image_1', Arr::get($attributes, 'image_1')) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="control-label">{{ __('Image 2') }}</label>
            {{ Form::mediaImage('image_2', Arr::get($attributes, 'image_2')) }}
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Logo') }}</label>
    {{ Form::mediaImage('logo', Arr::get($attributes, 'logo')) }}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" class="form-control" value="{{ Arr::get($attributes, 'title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" class="form-control" value="{{ Arr::get($attributes, 'subtitle') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Story text 1') }}</label>
    <textarea name="story_text_1" class="form-control" rows="3">{{ Arr::get($attributes, 'story_text_1') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Story text 2') }}</label>
    <textarea name="story_text_2" class="form-control" rows="3">{{ Arr::get($attributes, 'story_text_2') }}</textarea>
</div>

<div class="p-2 border mb-2">
    @foreach(range(1, 5) as $i)
        <div class="form-group">
            <label class="control-label">{{ __('List item :number', ['number' => $i]) }}</label>
            <input type="text" name="list_item_{{ $i }}" class="form-control" value="{{ Arr::get($attributes, 'list_item_' . $i) }}">
        </div>
        <div class="form-group">
            <label class="control-label">{{ __('List item url :number', ['number' => $i]) }}</label>
            <input type="text" name="list_item_url_{{ $i }}" class="form-control" value="{{ Arr::get($attributes, 'list_item_url_' . $i) }}">
        </div>
    @endforeach
</div>
