@php
    $limit = (int) $shortcode->limit ?: 4;

    $posts = match ($shortcode->type) {
        'featured' => get_featured_posts($limit),
        'popular' => get_popular_posts($limit),
        'recent' => get_recent_posts($limit),
        default => get_latest_posts($limit),
    };
@endphp

<section class="blog-area pt-50 pb-50">
    <div class="container">
        <div class="blog-main-box">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="blogheader mb-20 d-flex align-items-center justify-content-between">
                        <div class="tpsection mb-20">
                            <h4 class="tpsection__title">{!! BaseHelper::clean($shortcode->title) !!}</h4>
                        </div>
                        <div class="tpallblog mb-20">
                            <h4 class="blog-btn">
                                <a href="{{ $shortcode->url ?: '#' }}">
                                    {{ __('All Blog') }} <i class="far fa-long-arrow-right"></i>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-3 col-md-4 col-sm-4">
                        <div class="blogitem mb-40">
                            <div class="blogitem__thumb fix mb-20">
                                <a href="{{ $post->url }}">
                                    <img src="{{ RvMedia::getImageUrl($post->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}">
                                </a>
                            </div>
                            <div class="blogitem__content">
                                <div class="blogitem__contetn-date mb-10">
                                    <ul>
                                        <li>
                                            <a class="date-color">{{ $post->created_at->format('M d, Y') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ $post->firstCategory->url }}">{{ $post->firstCategory->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <h4 class="blogitem__title">
                                    <a href="{{ $post->url }}">{{ $post->name }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
