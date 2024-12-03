<?php

use Botble\Ads\Models\Ads;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\MetaBox;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Models\BaseModel;
use Botble\Media\Facades\RvMedia;
use Botble\Page\Models\Page;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;

register_page_template([
    'default' => __('Default'),
    'full-width' => __('Full width'),
    'blank' => __('Blank (without header and footer)'),
]);

register_sidebar([
    'id' => 'footer_sidebar',
    'name' => __('Footer sidebar'),
    'description' => __('Widgets in footer of page'),
]);

register_sidebar([
    'id' => 'footer_middle_sidebar',
    'name' => __('Footer middle sidebar'),
    'description' => __('Widgets in middle footer of page'),
]);

register_sidebar([
    'id' => 'footer_bottom_sidebar',
    'name' => __('Footer bottom sidebar'),
    'description' => __('Widgets in bottom footer of page'),
]);

register_sidebar([
    'id' => 'blog_sidebar',
    'name' => __('Blog sidebar'),
    'description' => __('Widgets in blog page'),
]);

register_sidebar([
    'id' => 'product_detail_sidebar',
    'name' => __('Product detail sidebar'),
    'description' => __('Widgets in the product detail page'),
]);

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function (FormAbstract $form, BaseModel $model) {
    Assets::addScriptsDirectly(Theme::asset()->url('js/page.js'));

    switch ($model::class) {
        case SimpleSliderItem::class:
            $model->loadMissing('metadata');

            $form
                ->addAfter('title', 'subtitle', 'text', [
                    'label' => __('Subtitle'),
                    'value' => $model->getMetaData('subtitle', true),
                    'attr' => [
                        'placeholder' => __('Subtitle'),
                    ],
                ])
                ->addAfter('subtitle', 'action_label', 'text', [
                    'label' => __('Button label'),
                    'value' => $model->getMetaData('action_label', true),
                    'attr' => [
                        'placeholder' => __('Ex: Shop Now'),
                    ],
                ]);

            break;
        case Ads::class:
            $model->loadMissing('metadata');

            $form
                ->addAfter('name', 'subtitle', 'textarea', [
                    'label' => __('Subtitle'),
                    'value' => $model->getMetaData('subtitle', true),
                    'attr' => [
                        'placeholder' => __('Subtitle'),
                        'rows' => 2,
                    ],
                ]);

            break;
        case Page::class:
            $model->loadMissing('metadata');

            $form
                ->addAfter('template', 'header_style', 'customSelect', [
                    'label' => __('Header style'),
                    'choices' => [
                        'inherit' => __('Inherit (use header style from theme options)'),
                        'default' => __('Default'),
                        'centered-logo' => __('Centered logo'),
                        'collapsed' => __('Collapsed'),
                    ],
                    'selected' => $model->getMetaData('header_style', true) ?: 'inherit',
                ])
                ->addAfter('image', 'banner_image', is_in_admin(true) ? 'mediaImage' : 'customImage', [
                    'label' => __('Banner image (1920x200px)'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('banner_image', true),
                ])
                ->addAfter('banner_image', 'customize_footer', 'customSelect', [
                    'label' => __('Customize footer'),
                    'label_attr' => ['class' => 'control-label'],
                    'choices' => [
                        'inherit' => __('Inherit (use footer style from theme options)'),
                        'custom' => __('Custom'),
                    ],
                    'selected' => $model->getMetaData('customize_footer', true) ?: 'inherit',
                ])
                ->addAfter('customize_footer', 'footer_background_color', 'customColor', [
                    'label' => __('Footer background color'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('footer_background_color', true) ?: theme_option('footer_background_color', '#040404'),
                ])
                ->addAfter('footer_background_color', 'footer_text_color', 'customColor', [
                    'label' => __('Footer text color'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('footer_text_color', true) ?: theme_option('footer_text_color', '#fff'),
                ])
                ->addAfter('footer_text_color', 'footer_text_muted_color', 'customColor', [
                    'label' => __('Footer text muted color'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('footer_text_muted_color', true) ?: theme_option('footer_text_muted_color', '#a0a0a0'),
                ])
                ->addAfter('footer_text_muted_color', 'footer_logo', 'mediaImage', [
                    'label' => __('Footer logo'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('footer_logo', true) ?: theme_option('logo_light'),
                ])
                ->addAfter('footer_logo', 'footer_border_color', 'customColor', [
                    'label' => __('Footer border color'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('footer_border_color', true) ?: theme_option('footer_border_color', '#282828'),
                ])
                ->addAfter('footer_border_color', 'footer_bottom_background_color', 'customColor', [
                    'label' => __('Footer bottom background color'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $model->getMetaData('footer_bottom_background_color', true) ?: theme_option('footer_bottom_background_color', '#040404'),
                ]);

            break;
    }

    return $form;
}, 127, 3);

add_action(
    [BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT],
    function (string $screen, Request $request, BaseModel $model) {
        switch (true) {
            case $model instanceof SimpleSliderItem:
                if ($request->has('subtitle')) {
                    MetaBox::saveMetaBoxData($model, 'subtitle', $request->input('subtitle'));
                }

                if ($request->has('action_label')) {
                    MetaBox::saveMetaBoxData($model, 'action_label', $request->input('action_label'));
                }

                break;
            case $model instanceof Ads:
                if ($request->has('subtitle')) {
                    MetaBox::saveMetaBoxData($model, 'subtitle', $request->input('subtitle'));
                }

                break;
            case $model instanceof Page:
                $fields = [
                    'header_style',
                    'banner_image',
                    'customize_footer',
                    'footer_background_color',
                    'footer_border_color',
                    'footer_text_color',
                    'footer_text_muted_color',
                    'footer_logo',
                    'footer_bottom_background_color',
                ];

                foreach ($fields as $field) {
                    if (! $request->has($field)) {
                        continue;
                    }

                    MetaBox::saveMetaBoxData($model, $field, $request->input($field));
                }

                break;
        }
    },
    230,
    3
);

RvMedia::setUploadPathAndURLToPublic();

RvMedia::addSize('small', 300, 300);
RvMedia::addSize('medium', 720, 720);

if (! function_exists('get_currencies_json')) {
    function get_currencies_json(): array
    {
        $currency = get_application_currency();
        $numberAfterDot = $currency->decimals ?: 0;

        return [
            'display_big_money' => config('plugins.ecommerce.general.display_big_money_in_million_billion'),
            'billion' => __('billion'),
            'million' => __('million'),
            'is_prefix_symbol' => $currency->is_prefix_symbol,
            'symbol' => $currency->symbol,
            'title' => $currency->title,
            'decimal_separator' => get_ecommerce_setting('decimal_separator', '.'),
            'thousands_separator' => get_ecommerce_setting('thousands_separator', ','),
            'number_after_dot' => $numberAfterDot,
            'show_symbol_or_title' => true,
        ];
    }
}

app()->booted(function () {
    add_filter('ecommerce_number_of_products_display_options', function (): array {
        return [
            20 => 20,
            30 => 30,
            40 => 40,
            60 => 60,
        ];
    }, 120);
});

if (! function_exists('get_product_layouts')) {
    function get_product_layouts(): array
    {
        return ['list' => __('List'), 'grid' => __('Grid')];
    }
}

if (! function_exists('get_default_product_layout')) {
    function get_default_product_layout(): string
    {
        $defaultLayout = 'grid';

        $layout = theme_option('default_product_list_layout', $defaultLayout);

        return ($layout !== $defaultLayout && array_key_exists($layout, get_product_layouts())) ? $layout : $defaultLayout;
    }
}

if (! function_exists('get_current_product_layout')) {
    function get_current_product_layout(): string
    {
        $defaultLayout = get_default_product_layout();

        $layout = BaseHelper::clean(request()->input('layout', $defaultLayout));

        return ($layout !== $defaultLayout && array_key_exists($layout, get_product_layouts())) ? $layout : $defaultLayout;
    }
}
