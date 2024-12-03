<div class="slider-pagination-2 p-relative">
    <div class="swiper-containers slidertwo-active">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide slider-bg">
                    <div class="container">
                        <div class="slider-top-padding pt-55">
                            <div class="row p-relative align-items-end">
                                <div class="col-xl-5 col-lg-6 col-md-6 d-flex align-self-center">
                                    <div class="tpslidertwo__item">
                                        <div class="tpslidertwo__content">
                                            @if($subtitle = $slider->getMetaData('subtitle', true))
                                                <h4 class="tpslidertwo__sub-title">{!! BaseHelper::clean($subtitle) !!}</h4>
                                            @endif
                                            @if($slider->title)
                                                    <h3 class="tpslidertwo__title mb-10">{!! BaseHelper::clean($slider->title) !!}</h3>
                                            @endif
                                            @if($description = $slider->description)
                                                <div>{!! BaseHelper::clean($description) !!}</div>
                                            @endif
                                            @if(($actionLabel = $slider->getMetaData('action_label', true)) && $slider->link)
                                                <div class="tpslidertwo__slide-btn">
                                                    <a class="tp-btn banner-animation" href="{{ $slider->link }}">
                                                        {{ $actionLabel }}
                                                        <i class="fal fa-long-arrow-right"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-7 col-lg-6 col-md-6 d-none d-md-block">
                                    <div class="tpslidertwo__img p-relative text-end">
                                        <img src="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $slider->title }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="slider-two-pagination">
        <div class="container">
            <div class="slider-two-pagination-item p-relative">
                <div class="slidertwo_pagination"></div>
            </div>
        </div>
    </div>
</div>
