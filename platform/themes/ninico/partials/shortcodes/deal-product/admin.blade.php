<div class="form-group">
    <label class="control-label">{{ __('Flash sale') }}</label>
    {{ Form::customSelect('flash_sale_id', $flashSales, Arr::get($attributes, 'flash_sale_id')) }}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Style') }}</label>
    {{ Form::customSelect('style', $styles, Arr::get($attributes, 'style')) }}
</div>

<section class="border p-2">
    {{ Form::helper(__('Marque only works with cosmetics style.')) }}

    <div class="form-group">
        <label class="control-label">{{ __('Marque text') }}</label>
        <input type="text" name="marque_text" class="form-control" value="{{ Arr::get($attributes, 'marque_text') }}">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Marque highlight text') }}</label>
                <input type="text" name="marque_highlight_text" class="form-control" value="{{ Arr::get($attributes, 'marque_highlight_text') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Marque highlight URL') }}</label>
                <input type="text" name="marque_highlight_url" class="form-control" value="{{ Arr::get($attributes, 'marque_highlight_url') }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Highlight background image') }}</label>
        {{ Form::mediaImage('highlight_background', Arr::get($attributes, 'highlight_background')) }}
    </div>
</section>
