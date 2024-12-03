@php
    $crumbs = Theme::breadcrumb()->getCrumbs();
    $pageTitle = Theme::get('pageTitle') ?: ($crumbs ? Arr::get(Arr::last($crumbs), 'label') : SeoHelper::getTitle());
@endphp

<section class="breadcrumb__area pt-60 pb-60 tp-breadcrumb__bg" data-background="{{ Theme::get('breadcrumbBannerImage') ?: RvMedia::getImageUrl(theme_option('breadcrumb_background'), null, false, RvMedia::getDefaultImage()) }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-7 col-lg-12 col-md-12 col-12">
                <div class="tp-breadcrumb">
                    @if($crumbs)
                        <div class="tp-breadcrumb__link mb-10">
                            @foreach($crumbs as $crumb)
                                <span @class(['breadcrumb-item-active' => $loop->first])>
                                    @if($loop->first)
                                        <a href="{{ $crumb['url'] }}">{!! BaseHelper::clean($crumb['label']) !!}</a>
                                    @else
                                        {!! BaseHelper::clean($crumb['label']) !!}
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <h2 class="tp-breadcrumb__title">{{ $pageTitle }}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
