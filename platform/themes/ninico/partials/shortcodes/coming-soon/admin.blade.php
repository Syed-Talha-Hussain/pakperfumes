<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Time end') }}</label>
    <input type="date" name="time" value="{{ Arr::get($attributes, 'time') }}" class="form-control" placeholder="{{ __('Time end') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Background image') }}</label>
    {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Logo style') }}</label>
    {{ Form::customSelect('logo_style', [theme_option('logo_light') => __('Light'), theme_option('logo_dark') => __('Dark')]) }}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Show subscribe form?') }}</label>
    {{ Form::customSelect('show_subscribe_form', [0 => __('No'), 1 => __('Yes')]) }}
</div>
