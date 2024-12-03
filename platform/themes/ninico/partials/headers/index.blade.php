@php
    $headerStyle = Theme::get('headerStyle', 'inherit');

    if ($headerStyle === 'inherit') {
        $headerStyle = theme_option('header_style', 'default');
    }

    $headerStyle = in_array($headerStyle, ['default', 'centered-logo', 'collapsed']) ? $headerStyle : 'default';
@endphp

{!! Theme::partial("headers.$headerStyle") !!}
