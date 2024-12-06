<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <meta name="description" content="@yield('description', 'Pakperfumes Website')" /> --}}
        <meta name="description" content="@yield('description')" />

        {!! BaseHelper::googleFonts(sprintf('https://fonts.googleapis.com/css2?family=%s:wght@400;500;600', urlencode($primaryFont = theme_option('primary_font', 'Jost')))) !!}

        <style>
            :root {
                --primary-color: {{ $primaryColor = theme_option('primary_color', '#d51243') }};
                --primary-color-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColor)) }};
                --primary-font: '{{ $primaryFont }}', sans-serif;
            }
        </style>

        {!! Theme::header() !!}
    </head>
    <body @if (BaseHelper::siteLanguageDirection() === 'rtl') dir="rtl" @endif>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        @if(theme_option('preloader_enabled', 'yes') === 'yes')
            {!! Theme::partial('preloader') !!}
        @endif

        {!! Theme::partial('scroll-top') !!}

        @yield('content')

        <script>
            'use strict';

            window.trans = {};
            window.siteConfig = {};
            @if (is_plugin_active('ecommerce'))
                window.currencies = @json(get_currencies_json());
                @if(EcommerceHelper::isCartEnabled())
                    siteConfig.ajaxCart = '{{ route('public.ajax.cart') }}';
                    siteConfig.cartUrl = '{{ route('public.cart') }}';
                @endif
            @endif
        </script>

        {!! Theme::footer() !!}
    </body>
</html>
