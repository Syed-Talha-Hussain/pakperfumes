<div class="tpproduct pb-15 mb-30">
    <div class="tpproduct__thumb p-relative">
        @if ($product->productLabels->count())
            <div class="product__badge-list">
                @foreach ($product->productLabels as $label)
                    <span class="tpproduct__thumb-topsall" @style(["background-color: $label->color" => $label->color])>
                    <span class="product__badge-item">{{ $label->name }}</span>
                </span>
                @endforeach
            </div>
        @endif
        <a href="{{ $product->url }}">
            <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
            <img class="product-thumb-secondary" src="{{ RvMedia::getImageUrl(Arr::get($product->images, 2, $product->image), 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
        </a>
        <div class="tpproduct__thumb-action">
            @if (EcommerceHelper::isCompareEnabled())
                <a class="add-to-compare" href="{{ route('public.compare.add', $product->id) }}"><i class="fal fa-exchange"></i></a>
            @endif
            <a class="quickview" href="{{ route('public.ajax.quick-view', $product->id) }}"><i class="fal fa-eye"></i></a>
            @if (EcommerceHelper::isWishlistEnabled())
                <a class="wishlist add-to-wishlist" href="{{ route('public.wishlist.add', $product->getKey()) }}"><i class="fal fa-heart"></i></a>
            @endif
        </div>
    </div>
    <div class="tpproduct__content">
        <h3 class="tpproduct__title">
            <a href="{{ $product->url }}">{{ $product->name }}</a>
        </h3>
        <div class="tpproduct__priceinfo p-relative">
            <div class="tpproduct__priceinfo-list">
                <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                @if($product->isOnSale())
                    <span class="tpproduct__priceinfo-list-oldprice">{{ format_price($product->price_with_taxes) }}</span>
                @endif
            </div>
            @if(EcommerceHelper::isCartEnabled())
                <div class="tpproduct__cart">
                    @if ($product->variations()->exists())
                        <a data-id="{{ $product->id }}" href="{{ route('public.ajax.quick-shop', $product->id) }}" class="button-quick-shop">
                            <i class="fal fa-shopping-cart"></i>
                            <span>{{ __('Select options') }}</span>
                        </a>
                    @else
                        <a data-id="{{ $product->id }}" href="{{ route('public.cart.add-to-cart') }}" class="add-to-cart">
                            <i class="fal fa-shopping-cart"></i>
                            <span>{{ __('Add To Cart') }}</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
