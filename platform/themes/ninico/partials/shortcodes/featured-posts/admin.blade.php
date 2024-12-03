@php
    $types = [
        '' => __('Latest'),
        'featured' => __('Featured'),
        'popular' => __('Popular'),
        'recent' => __('Recent'),
    ];
@endphp

<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" class="form-control" value="{{ Arr::get($attributes, 'title') }}">
    {{ Form::helper(__('Wrapper text into <code>:tag</code> tag to make it highlight.', ['tag' => '&lt;span&gt;text&lt;/span&gt;'])) }}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Limit') }}</label>
    <input type="text" name="limit" class="form-control" value="{{ Arr::get($attributes, 'limit') }}" placeholder="{{ __('Number of posts to display') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Post type') }}</label>
    {{ Form::customSelect('type', $types, Arr::get($attributes, 'type')) }}
</div>

<div class="form-group">
    <label class="control-label">{{ __('URL') }}</label>
    <input type="text" name="url" class="form-control" value="{{ Arr::get($attributes, 'url') }}" placeholder="{{ __('URL') }}">
</div>
