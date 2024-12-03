<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    {{ Form::helper(__('Wrapper text into <code>:tag</code> tag to make it highlight.', ['tag' => '&lt;span&gt;text&lt;/span&gt;'])) }}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Categories') }}</label>
    <input type="text" name="category_ids" data-list="{{ json_encode($categories) }}" value="{{ Arr::get($attributes, 'category_ids') }}" class="form-control list-tagify" placeholder="{{ __('Choose categories') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Style') }}</label>
    {{ Form::customSelect('style', ['wooden' => __('Wooden'), 'fashion' => __('Fashion'), 'cosmetics' => __('Cosmetics')], Arr::get($attributes, 'style')) }}
</div>
