@if ($config['image'])
    <div class="col-xl-6 col-lg-5 col-md-7 col-sm-12">
        <div class="footer-copyright__brand">
            @if($url = $config['url'])
                <a href="{{ $url }}">
                    <img src="{{ RvMedia::getImageUrl($config['image']) }}" alt="{{ theme_option('site_name') }}">
                </a>
            @else
                <img src="{{ RvMedia::getImageUrl($config['image']) }}" alt="{{ theme_option('site_name') }}">
            @endif
        </div>
    </div>
@endif
