@php
    $fields = [
        'title' => [
            'type' => 'text',
            'title' => __('Title'),
            'required' => true
        ],
        'subtitle' => [
            'type' => 'text',
            'title' => __('Subtitle'),
        ],
        'description' => [
            'type' => 'textarea',
            'title' => __('Description'),
        ],
        'image' => [
            'type' => 'image',
            'title' => __('Image'),
        ],
        'button_label' => [
            'type' => 'text',
            'title' => __('Button label'),
        ],
        'button_url' => [
            'type' => 'text',
            'title' => __('Button URL'),
        ],
    ];
    $max = 5;
@endphp

{!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'max', 'attributes')) !!}
