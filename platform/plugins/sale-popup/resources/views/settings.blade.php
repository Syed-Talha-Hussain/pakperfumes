@extends('core/base::layouts.master')

@section('content')
    <div class="max-width-1200">
        {!! Form::open(['url' => route('sale-popup.settings'), 'class' => 'main-setting-form']) !!}
        <x-core-setting::section
            :title="trans('plugins/sale-popup::sale-popup.setting.title')"
            :description="trans('plugins/sale-popup::sale-popup.setting.description')"
        >
            @if (!request()->filled('ref_lang'))
                <x-core-setting::checkbox
                    name="enabled"
                    :label="trans('plugins/sale-popup::sale-popup.enable')"
                    :checked="$salePopupHelper->getSetting('enabled', 1)"
                />

                <x-core-setting::select
                    class="ui-select select-full"
                    name="collection_id"
                    :label="trans('plugins/sale-popup::sale-popup.load_products_from')"
                    :options="['featured_products' => trans('plugins/sale-popup::sale-popup.featured_products')] +
                        get_product_collections()
                            ->pluck('name', 'id')
                            ->toArray()"
                    :value="$salePopupHelper->getSetting('collection_id')"
                />
            @endif

            <x-core-setting::text-input
                name="purchased_text"
                :label="trans('plugins/sale-popup::sale-popup.purchased_text')"
                :value="$salePopupHelper->getSetting('purchased_text', 'purchased')"
            />

            <x-core-setting::text-input
                name="verified_text"
                :label="trans('plugins/sale-popup::sale-popup.verified_text')"
                :value="$salePopupHelper->getSetting('verified_text', 'Verified')"
            />

            <x-core-setting::text-input
                name="quick_view_text"
                :label="trans('plugins/sale-popup::sale-popup.quick_view_text')"
                :value="$salePopupHelper->getSetting('quick_view_text', 'Quick view')"
            />

            <x-core-setting::textarea
                name="list_users_purchased"
                :label="trans('plugins/sale-popup::sale-popup.list_users_purchased')"
                :value="$salePopupHelper->getSetting(
                    'list_users_purchased',
                    'Nathan (California) | Alex (Texas) | Henry (New York) | Kiti (Ohio) | Daniel (Washington) | Hau (California) | Van (Ohio) | Sara (Montana)  | Kate (Georgia)',
                )"
                :helper-text="trans('plugins/sale-popup::sale-popup.user_separator')"
                rows="3"
            />

            @if (!request()->filled('ref_lang'))
                <x-core-setting::checkbox
                    name="show_time_ago_suggest"
                    :label="trans('plugins/sale-popup::sale-popup.show_time_ago_suggest')"
                    :checked="$salePopupHelper->getSetting('show_time_ago_suggest', 1)"
                />
            @endif

            <x-core-setting::textarea
                name="list_sale_time"
                :label="trans('plugins/sale-popup::sale-popup.list_sale_time')"
                :value="$salePopupHelper->getSetting(
                    'list_sale_time',
                    '4 hours ago | 2 hours ago | 45 minutes ago | 1 day ago | 8 hours ago | 10 hours ago | 25 minutes ago | 2 day ago | 5 hours ago | 40 minutes ago',
                )"
                :helper-text="trans('plugins/sale-popup::sale-popup.time_separator')"
                rows="3"
            />

            @if (!request()->filled('ref_lang'))
                <x-core-setting::text-input
                    name="limit_products"
                    type="number"
                    :label="trans('plugins/sale-popup::sale-popup.limit_products')"
                    :value="$salePopupHelper->getSetting('limit_products', 20)"
                />

                <x-core-setting::checkbox
                    name="show_verified"
                    :label="trans('plugins/sale-popup::sale-popup.show_verified')"
                    :checked="$salePopupHelper->getSetting('show_verified', 1)"
                />

                <x-core-setting::checkbox
                    name="show_close_button"
                    :label="trans('plugins/sale-popup::sale-popup.show_close_button')"
                    :checked="$salePopupHelper->getSetting('show_close_button', 1)"
                />

                <x-core-setting::checkbox
                    name="show_quick_view_button"
                    :label="trans('plugins/sale-popup::sale-popup.show_quick_view_button')"
                    :checked="$salePopupHelper->getSetting('show_quick_view_button', 1)"
                />

                <div class="form-group">
                    <label
                        class="text-title-field">{{ trans('plugins/sale-popup::sale-popup.select_pages_to_display') }}</label>
                    <div class="form-group form-group-no-margin">
                        <div class="multi-choices-widget list-item-checkbox">
                            <ul>
                                <li>
                                    <input
                                        class="styled available-countries"
                                        id="display-page-homepage"
                                        name="display_pages[]"
                                        type="checkbox"
                                        value="public.index"
                                        @if (in_array('public.index', $displayPages = json_decode($salePopupHelper->getSetting('display_pages', '["public.index"]'), true))) checked="checked" @endif
                                    >
                                    <label for="display-page-homepage">{{ __('Homepage') }}</label>
                                </li>
                                <li>
                                    <input
                                        class="styled available-countries"
                                        id="display-page-product"
                                        name="display_pages[]"
                                        type="checkbox"
                                        value="public.product"
                                        @if (in_array('public.product', $displayPages)) checked="checked" @endif
                                    >
                                    <label for="display-page-product">{{ __('Product page') }}</label>
                                </li>
                                <li>
                                    <input
                                        class="styled available-countries"
                                        id="display-page-products"
                                        name="display_pages[]"
                                        type="checkbox"
                                        value="public.products"
                                        @if (in_array('public.products', $displayPages)) checked="checked" @endif
                                    >
                                    <label for="display-page-products">{{ __('All products') }}</label>
                                </li>
                                <li>
                                    <input
                                        class="styled available-countries"
                                        id="display-page-cart"
                                        name="display_pages[]"
                                        type="checkbox"
                                        value="public.cart"
                                        @if (in_array('public.cart', $displayPages)) checked="checked" @endif
                                    >
                                    <label for="display-page-cart">{{ __('Cart page') }}</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <x-slot:pre-footer>
                <div class="mt-3">
                    {!! apply_filters(
                        'setting_sale_popup_meta_boxes',
                        null,
                        request()->route()->parameters(),
                    ) !!}
                </div>
            </x-slot:pre-footer>
        </x-core-setting::section>

        <div
            class="flexbox-annotated-section"
            style="border: none"
        >
            <div class="flexbox-annotated-section-annotation">
                &nbsp;
            </div>
            <div class="flexbox-annotated-section-content">
                <button
                    class="btn btn-info"
                    type="submit"
                >{{ trans('plugins/sale-popup::sale-popup.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
