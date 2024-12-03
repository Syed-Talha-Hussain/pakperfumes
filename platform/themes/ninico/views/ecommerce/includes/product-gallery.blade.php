<div class="tpproduct-details__nab pr-30 mb-40 product-gallery">
    <div class="product-gallery__wrapper">
        @foreach ($productImages as $img)
            <a href="{{ RvMedia::getImageUrl($img) }}">
                <img title="{{ $product->name }}" src="{{ RvMedia::getImageUrl($img) }}" data-lazy="{{ RvMedia::getImageUrl($img) }}">
            </a>
        @endforeach
    </div>
    <div class="product-thumbnails">
        @foreach ($productImages as $img)
            <img title="{{ $product->name }}" src="{{ RvMedia::getImageUrl($img, 'thumb') }}" data-src="{{ RvMedia::getImageUrl($img, 'thumb') }}">
        @endforeach
    </div>
</div>
