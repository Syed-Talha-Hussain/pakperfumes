<section class="banner-area pt-100 pb-95">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-3 col-md-3">
                <div class="banneritem__thumb banner-animation text-center p-relative">
                    @if($categories->isNotEmpty())
                        @php($category = $categories->first())
                        <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                        <div class="banneritem__content">
                            <a href="{{ $category->url }}">
                                <i class="far fa-long-arrow-right"></i>
                            </a>
                            <p>{{ __(':count Items', ['count' => $category->products_count]) }}</p>
                            <h4 class="banneritem__content-title">
                                <a href="{{ $category->url }}">{{ $category->name }}</a>
                            </h4>
                        </div>
                    @endif
                </div>
                <div class="banneritem__thumb banner-animation text-center p-relative">
                    @if($categories->count() > 1)
                        @php($category = $categories->skip(1)->first())
                        <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                        <div class="banneritem__content">
                            <a href="{{ $category->url }}">
                                <i class="far fa-long-arrow-right"></i>
                            </a>
                            <p>{{ __(':count Items', ['count' => $category->products_count]) }}</p>
                            <h4 class="banneritem__content-title">
                                <a href="{{ $category->url }}">{{ $category->name }}</a>
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="banneritem__thumb banner-animation text-center p-relative">
                    @if($categories->count() > 2)
                        @php($category = $categories->skip(2)->first())
                        <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                        <div class="banneritem__content">
                            <a href="{{ $category->url }}">
                                <i class="far fa-long-arrow-right"></i>
                            </a>
                            <p>{{ __(':count Items', ['count' => $category->products_count]) }}</p>
                            <h4 class="banneritem__content-title">
                                <a href="{{ $category->url }}">{{ $category->name }}</a>
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="banneritem__thumb banner-animation text-center p-relative">
                    @if($categories->count() > 3)
                        @php($category = $categories->skip(3)->first())
                        <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                        <div class="banneritem__content">
                            <a href="{{ $category->url }}">
                                <i class="far fa-long-arrow-right"></i>
                            </a>
                            <p>{{ __(':count Items', ['count' => $category->products_count]) }}</p>
                            <h4 class="banneritem__content-title">
                                <a href="{{ $category->url }}">{{ $category->name }}</a>
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
