@if(count($reviews) > 0)
<section class="testimonial-area pt-50 pb-50" @style(["background-color: $shortcode->background_color" => $shortcode->background_color])>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                @if($title = $shortcode->title)
                    <div class="tpsection mb-35">
                        <h4 class="tpsection__title">{!! BaseHelper::clean($title) !!}</h4>
                    </div>
                @endif
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="tptestiarrow tp-white-testimonial d-flex align-items-center justify-content-end">
                    <div class="tptestiarrow__prv"><i class="far fa-long-arrow-left"></i>{{ __('Prev') }}</div>
                    <div class="tptestiarrow__nxt">{{ __('Next') }}<i class="far fa-long-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="swiper-container testi-active">
            <div class="swiper-wrapper">
                @foreach($reviews as $review)
                    <div class="swiper-slide">
                        <div class="tptesti text-center" @style(["background-color: $shortcode->card_color" => $shortcode->card_color])>
                            <div class="tptesti__content pb-5">
                                <p>“ {!! BaseHelper::clean($review->comment) !!} ”</p>
                                    <div class="form-rating-stars ms-2 mb-1">
                                        <div class="tpproduct-details__rating">
                                            <div class="product-rating-wrapper">
                                                <div
                                                    class="product-rating"
                                                    style="width: {{ $review->star * 20 }}%"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="tptesti__avata d-flex align-items-center justify-content-center">
                                {{-- <div class="tptesti__avata-icon mr-20"> --}}
                                    @if($review->images && count($review->images))
                                    {{-- <img src="{{ RvMedia::getImageUrl($testimonial->image) }}" alt="{{ $testimonial->name }}"> --}}
                                    <div class="review-images">
                                        @foreach($review->images as $image)
                                            <a href="{{ RvMedia::getImageUrl($image) }}">
                                                <img src="{{ RvMedia::getImageUrl($image, 'thumb') }}" alt="{{ $review->comment }}" class="img-fluid rounded h-100">
                                            </a>
                                        @endforeach
                                    </div>

                                    @endif
                                {{-- </div> --}}
                                <div class="tptesti__avata-content text-start">
                                    {{-- <h5 class="tptesti__avata-content-title">{{ $testimonial->name }}</h5>
                                    <p>{{ $testimonial->company }}</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@else
    <p class="text-muted">{{ __('Looks like there are no reviews yet.') }}</p>
@endif
