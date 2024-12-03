<div class="header-search-bar">
    <form action="{{ route('public.products') }}" class="position-relative form--quick-search" data-url="{{ route('public.ajax.search-products') }}" method="GET">
        <div class="search-info p-relative">
            @if($hasCategorySelect = (theme_option('display_product_categories_select_on_header', 'yes') === 'yes'))
                <div class="product-category-label">
                    <span class="text text-truncate d-inline-block">{{ __('All Categories') }}</span>
                    <i class="fal fa-chevron-down ms-2"></i>
                </div>
                <select
                    class="default-select product-category-select"
                    name="categories[]"
                >
                    <option value="0">{{ __('All Categories') }}</option>
                    {!! ProductCategoryHelper::renderProductCategoriesSelect() !!}
                </select>
            @endif
            <input type="text" name="q" @class(['input-search-product', 'has-category-select' => $hasCategorySelect]) placeholder="{{ __('Search products...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}" autocomplete="off">
            <button class="header-search-icon">
                <i class="fal fa-search"></i>
            </button>
        </div>
        <div class="panel--search-result"></div>
    </form>
</div>
