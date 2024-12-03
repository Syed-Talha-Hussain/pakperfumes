<div class="form-group">
    <label class="control-label">{{ __('Categories') }}</label>
    <input type="text" name="category_ids" data-list="{{ json_encode($categories) }}" value="{{ Arr::get($attributes, 'category_ids') }}" class="form-control list-tagify" placeholder="{{ __('Choose categories') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Number of products per category') }}</label>
    <input type="number" name="number_of_products" value="{{ Arr::get($attributes, 'number_of_products', 4) }}" class="form-control" placeholder="{{ __('Number of products per category') }}">
</div>
