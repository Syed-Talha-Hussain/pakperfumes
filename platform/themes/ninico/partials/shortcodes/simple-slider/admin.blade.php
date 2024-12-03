<div class="form-group">
    <label class="control-label">{{ __('Style') }}</label>
    {{ Form::customSelect('style', $styles, Arr::get($attributes, 'style')) }}
</div>

@foreach(range(1, 2) as $i)
    <div class="form-group">
        <label class="control-label">{{ __('Ads :number', ['number' => $i]) }}</label>
        <div class="ui-select-wrapper form-group">
            <select name="ads_{{ $i }}" class="form-control ui-select">
                <option value="">{{ __('-- Select --') }}</option>
                @foreach($ads as $ad)
                    <option value="{{ $ad->key }}" @selected($ad->key === Arr::get($attributes, 'ads_' . $i))>{{ $ad->name }}</option>
                @endforeach
            </select>
            <svg class="svg-next-icon svg-next-icon-size-16">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
            </svg>
        </div>
    </div>
@endforeach

<section class="border p-2">
    {{ Form::helper(__('Settings in this section only works with style "Grocery"')) }}
    <div class="form-group">
        <label class="control-label">{{ __('Background image') }}</label>
        {{ Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) }}
    </div>
</section>
