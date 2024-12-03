<div class="form-group">
    <label class="control-label">{{ __('Style') }}</label>
    {{ Form::customSelect('style', ['fashion' => __('Fashion'), 'furniture' => __('Furniture')], Arr::get($attributes, 'style')) }}
</div>

@foreach(range(1, 3) as $i)
    <div class="form-group">
        <label class="control-label">{{ __('Ad :number', ['number' => $i]) }}</label>
        {{ Form::customSelect("key_$i", $ads->pluck('name', 'key')->merge(['' => __('-- Select --')])->sortKeys(), Arr::get($attributes, 'key_' . $i)) }}
    </div>
@endforeach
