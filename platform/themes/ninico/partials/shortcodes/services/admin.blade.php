@php
    $fields = [
        'title' => [
            'type' => 'text',
            'title' => __('Title'),
            'required' => true,
        ],
        'description' => [
            'type' => 'text',
            'title' => __('Description'),
        ],
        'image' => [
            'type' => 'image',
            'title' => __('Image'),
        ],
    ];
@endphp

{!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
