<div class="container">
    <div class="row align-items-center">
        <div class="col-xl-2 col-lg-3">
            <div class="logo">
                <a href="{{ route('public.index') }}">
                    <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}">
                </a>
            </div>
        </div>
        @if(is_plugin_active('ecommerce'))
            <div class="col-xl-10 col-lg-9">
                <div class="header-meta-info d-flex align-items-center justify-content-between">
                    {!! Theme::partial('header-search-bar') !!}
                    {!! Theme::partial('header-meta') !!}
                </div>
            </div>
        @endif
    </div>
</div>
