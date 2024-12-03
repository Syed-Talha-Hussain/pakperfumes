@php
    $fields = [
        'name' => [
            'title' => __('Name'),
            'required' => true
        ],
        'image' => [
            'type' => 'image',
            'title' => __('Logo'),
            'required' => true
        ],
        'link' => [
            'type' => 'text',
            'title' => __('URL'),
            'required' => false
        ],
    ];
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Title text color') }}</label>
        {{ Form::customColor('title_color', Arr::get($attributes, 'title_color')) }}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background color') }}</label>
        {{ Form::customColor('background_color', Arr::get($attributes, 'background_color')) }}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background image') }}</label>
        {{ Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) }}
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
