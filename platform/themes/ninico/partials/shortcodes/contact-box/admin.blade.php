<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="p-2 border mb-2">
    <div class="form-group">
        <label class="control-label">{{ __('Address') }}</label>
        <input type="text" name="address" value="{{ Arr::get($attributes, 'address') }}" class="form-control">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Phone') }}</label>
        <input type="text" name="phone" value="{{ Arr::get($attributes, 'phone') }}" class="form-control">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Email') }}</label>
        <input type="text" name="email" value="{{ Arr::get($attributes, 'email') }}" class="form-control">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Hours') }}</label>
        <input type="text" name="hours" value="{{ Arr::get($attributes, 'hours') }}" class="form-control">
    </div>
</div>

@if (is_plugin_active('contact'))
    <div class="form-group">
        <label class="control-label">{{ __('Show contact form?') }}</label>
        <select name="show_contact_form" class="form-control">
            <option value="0" @selected(! Arr::get($attributes, 'show_contact_form'))>{{ __('No') }}</option>
            <option value="1" @selected(Arr::get($attributes, 'show_contact_form'))>{{ __('Yes') }}</option>
        </select>
    </div>
@endif

@foreach(range(1, 2) as $i)
    <div class="p-2 border mb-2">
        <div class="form-group">
            <label class="control-label">{{ __('Button label :number', ['number' => $i]) }}</label>
            <input type="text" name="button_label_{{ $i }}" value="{{ Arr::get($attributes, 'button_label_' . $i) }}" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">{{ __('Button URL :number', ['number' => $i]) }}</label>
            <input type="text" name="button_url_{{ $i }}" value="{{ Arr::get($attributes, 'button_url_' . $i) }}" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">{{ __('Button icon :number', ['number' => $i]) }}</label>
            {{ Form::themeIcon('button_icon_' . $i, Arr::get($attributes, 'button_icon_' . $i)) }}
        </div>
    </div>
@endforeach
