<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Limit') }}</label>
    <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit') }}" class="form-control" placeholder="{{ __('Number of categories to display') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Tabs') }}</label>
    <div class="mt-2">
        @foreach($tabs as $key => $label)
            <label class="me-2">
                <input type="checkbox" name="tabs[]" value="{{ $key }}" @if (in_array($key, $selectedTabs)) checked @endif> {{ $label }}
            </label>
        @endforeach
    </div>
</div>
