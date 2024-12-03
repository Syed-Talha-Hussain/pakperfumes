@php
    $attributes['quantity'] = 4;

    $fields = [
        'name' => [
            'type' => 'text',
            'title' => __('Name'),
            'required' => true
        ],
        'address' => [
            'type' => 'text',
            'title' => __('Address'),
        ],
        'phone' => [
            'type' => 'text',
            'title' => __('Phone number'),
        ],
        'hours' => [
            'type' => 'text',
            'title' => __('Store hours'),
        ],
        'image' => [
            'type' => 'image',
            'title' => __('Image'),
        ],
    ];
    $max = 10;
@endphp

{!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'max', 'attributes')) !!}
