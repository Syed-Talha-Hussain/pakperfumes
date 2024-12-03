<div @class(['header-top', $class ?? 'space-bg'])>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 col-lg-12 col-md-12">
                @if(theme_option('header_messages') && $headerMessages = json_decode(theme_option('header_messages'), true))
                    @php($message = collect($headerMessages[array_rand($headerMessages)])->pluck('value', 'key'))
                    @if ($message->get('message') && $message->get('link_text'))
                        <div class="header-welcome-text">
                            <span>{!! BaseHelper::clean($message->get('message')) !!}</span>
                            <a href="{{ $message->get('link') }}" class="ms-2">
                                {!! BaseHelper::clean($message->get('link_text')) !!} <i class="fal fa-long-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                @endif
            </div>
            <div class="col-xl-4 d-none d-xl-block">
                <div class="headertoplag d-flex align-items-center justify-content-end">
                    {!! Theme::partial('currency-switcher') !!}
                    {!! Theme::partial('language-switcher') !!}
                    @if(theme_option('social_links') && $socialLinks = json_decode(theme_option('social_links'), true))
                        <div class="menu-top-social">
                            @foreach($socialLinks as $socialLink)
                                @php($socialLink = collect($socialLink)->pluck('value', 'key'))
                                <a href="{{ $socialLink->get('url') }}">
                                    <i class="{{ $socialLink->get('icon') }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
