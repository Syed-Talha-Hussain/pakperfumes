<div class="form-group">
    <label class="control-label">{{ __('Collections') }}</label>
    <input type="text" name="collection_ids" data-list="{{ json_encode($collections) }}" value="{{ Arr::get($attributes, 'collection_ids') }}" class="form-control list-tagify" placeholder="{{ __('Choose collections') }}">
</div>
