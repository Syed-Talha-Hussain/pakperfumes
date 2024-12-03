<?php

use Botble\Ads\Facades\AdsManager;
use Botble\Base\Facades\Html;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductCollection;
use Botble\Ecommerce\Models\Review;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Team\Models\Team;
use Botble\Testimonial\Models\Testimonial;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace('partials.shortcodes.simple-slider.index');
        });

        add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function (string $html, string $key, array $attributes) {
            if ($key !== 'simple-slider') {
                return $html;
            }

            $ads = [];

            if (is_plugin_active('ads')) {
                $ads = AdsManager::getData(true, true);
            }

            $styles = [
                'wooden' => __('Wooden'),
                'fashion' => __('Fashion'),
                'furniture' => __('Furniture'),
                'cosmetics' => __('Cosmetics'),
                'grocery' => __('Grocery'),
            ];

            return $html . Theme::partial('shortcodes.simple-slider.admin', compact('ads', 'styles', 'attributes'));
        }, 50, 3);
    }

    if (is_plugin_active('gallery')) {
        add_filter('galleries_box_template_view', function () {
            return Theme::getThemeNamespace('partials.shortcodes.galleries.index');
        });

        add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function (string $data, string $key, array $attributes) {
            if ($key !== 'gallery' && function_exists('get_galleries')) {
                return $data;
            }

            return $data . Theme::partial('shortcodes.galleries.admin', compact('attributes'));
        }, arguments: 3);
    }

    if (is_plugin_active('ecommerce')) {
        Shortcode::register(
            'product-categories',
            __('Product Categories'),
            __('Product Categories'),
            function (ShortcodeCompiler $shortcode) {
                $categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode);

                if (! $categoryIds) {
                    return null;
                }

                $categories = ProductCategory::query()
                    ->whereIn('id', $categoryIds)
                    ->wherePublished()
                    ->with('slugable')
                    ->withCount('products')
                    ->get();

                if ($categories->isEmpty()) {
                    return null;
                }

                $style = ! in_array($shortcode->style, ['wooden', 'fashion', 'cosmetics']) ? 'wooden' : $shortcode->style;

                return Theme::partial(
                    "shortcodes.product-categories.styles.$style",
                    compact('shortcode', 'categories')
                );
            }
        );

        Shortcode::setAdminConfig('product-categories', function (array $attributes) {
            $categories = ProductCategory::query()
                ->wherePublished()
                ->pluck('name', 'id');

            return Html::style('vendor/core/core/base/libraries/tagify/tagify.css') .
                Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
                Html::script('vendor/core/core/base/js/tags.js') .
                Theme::partial('shortcodes.product-categories.admin', compact('attributes', 'categories'));
        });

        Shortcode::register(
            'products-by-categories',
            __('Products by Categories'),
            __('Products by Categories'),
            function (ShortcodeCompiler $shortcode) {
                $categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode);

                if (! $categoryIds) {
                    return null;
                }

                $categories = ProductCategory::query()
                    ->wherePublished()
                    ->whereIn('id', $categoryIds)
                    ->with('products', function (BelongsToMany $query) use ($shortcode) {
                        $query
                            ->withAvg('reviews', 'star');
                    })
                    ->get();

                if ($categories->isEmpty()) {
                    return null;
                }

                foreach ($categories as $category) {
                    $category->products = $category->products->take((int) $shortcode->number_of_products ?: 4);
                }

                return Theme::partial(
                    'shortcodes.products-by-categories.index',
                    compact('shortcode', 'categories')
                );
            }
        );

        Shortcode::setAdminConfig('products-by-categories', function (array $attributes) {
            $categories = ProductCategory::query()
                ->wherePublished()
                ->pluck('name', 'id');

            return Html::style('vendor/core/core/base/libraries/tagify/tagify.css') .
                Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
                Html::script('vendor/core/core/base/js/tags.js') .
                Theme::partial('shortcodes.products-by-categories.admin', compact('attributes', 'categories'));
        });

        Shortcode::register('products', __('Products'), __('Products'), function (ShortcodeCompiler $shortcode) {
            $tabs = [
                'all' => __('All'),
                'featured' => __('Featured'),
                'on-sale' => __('On sale'),
                'trending' => __('Trending'),
                'top-rated' => __('Top rated'),
            ];

            $selectedTabs = array_filter(explode(',', $shortcode->tabs));

            if (empty($selectedTabs)) {
                $selectedTabs = array_keys($tabs);
            }

            return Theme::partial('shortcodes.products.index', compact('shortcode', 'tabs', 'selectedTabs'));
        });

        Shortcode::setAdminConfig('products', function (array $attributes) {
            $tabs = [
                'all' => __('All'),
                'featured' => __('Featured'),
                'on-sale' => __('On sale'),
                'trending' => __('Trending'),
                'top-rated' => __('Top rated'),
            ];

            $selectedTabs = array_filter(explode(',', Arr::get($attributes, 'tabs')));

            if (empty($selectedTabs)) {
                $selectedTabs = array_keys($tabs);
            }

            return Theme::partial('shortcodes.products.admin', compact('attributes', 'tabs', 'selectedTabs'));
        });

        Shortcode::register('deal-product', __('Deal Product'), __('Deal Product'), function (ShortcodeCompiler $shortcode) {
            if (! $shortcode->flash_sale_id) {
                return null;
            }

            $flashSale = FlashSale::query()
                ->wherePublished()
                ->notExpired()
                ->with('products', function (BelongsToMany $query) {
                    $query->inRandomOrder()->limit(1);
                })
                ->withCount('products')
                ->find($shortcode->flash_sale_id);

            if (! $flashSale || $flashSale->products_count === 0) {
                return null;
            }

            $product = $flashSale->products->first();

            if (! $product) {
                return null;
            }

            Theme::asset()->container('footer')->usePath()->add('countdown-js', 'js/countdown.js');

            $style = ! in_array($shortcode->style, ['wooden', 'cosmetics']) ? 'wooden' : $shortcode->style;

            return Theme::partial('shortcodes.deal-product.index', compact('shortcode', 'style', 'flashSale', 'product'));
        });

        Shortcode::setAdminConfig('deal-product', function (array $attributes) {
            $flashSales = FlashSale::query()
                ->wherePublished()
                ->notExpired()
                ->pluck('name', 'id');

            $styles = [
                'wooden' => __('Wooden'),
                'cosmetics' => __('Cosmetics'),
            ];

            return Theme::partial('shortcodes.deal-product.admin', compact('attributes', 'styles', 'flashSales'));
        });

        Shortcode::register('products-slide', __('Products Slide'), __('Products Slide'), function (ShortcodeCompiler $shortcode) {
            $params = array_merge([
                'take' => (int)$shortcode->limit ?: 5,
            ], EcommerceHelper::withReviewsParams());

            $products = match ($shortcode->type) {
                'featured' => get_featured_products($params),
                'trending' => get_trending_products($params),
                'latest' => get_products($params),
            };

            return Theme::partial('shortcodes.products-slide.index', compact('shortcode', 'products'));
        });

        Shortcode::setAdminConfig('products-slide', function (array $attributes) {
            $types = [
                'featured' => __('Featured'),
                'trending' => __('Trending'),
                'latest' => __('Latest'),
            ];

            return Theme::partial('shortcodes.products-slide.admin', compact('attributes', 'types'));
        });

        Shortcode::register('product-collections', __('Product Collections'), __('Product Collections'), function (ShortcodeCompiler $shortcode) {
            $collectionIds = Shortcode::fields()->getIds('collection_ids', $shortcode);

            if (! $collectionIds) {
                return null;
            }

            $collections = ProductCollection::query()
                ->wherePublished()
                ->whereIn('id', $collectionIds)
                ->get();

            if ($collections->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.product-collections.index', compact('shortcode', 'collections'));
        });

        Shortcode::setAdminConfig('product-collections', function (array $attributes) {
            $collections = ProductCollection::query()
                ->wherePublished()
                ->pluck('name', 'id');

            return Html::style('vendor/core/core/base/libraries/tagify/tagify.css') .
                Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
                Html::script('vendor/core/core/base/js/tags.js') .
                Theme::partial('shortcodes.product-collections.admin', compact('attributes', 'collections'));
        });
    }

    if (is_plugin_active('ads')) {
        Shortcode::register('theme-ads', __('Theme Ads'), __('Theme Ads'), function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.theme-ads.index', compact('shortcode'));
        });

        Shortcode::setAdminConfig('theme-ads', function (array $attributes) {
            $ads = AdsManager::getData(true, true);

            return Theme::partial('shortcodes.theme-ads.admin', compact('ads', 'attributes'));
        });
    }

    if (is_plugin_active('blog')) {
        Shortcode::register(
            'featured-posts',
            __('Featured Posts'),
            __('Featured Posts'),
            function (ShortcodeCompiler $shortcode) {
                return Theme::partial('shortcodes.featured-posts.index', compact('shortcode'));
            }
        );

        Shortcode::setAdminConfig('featured-posts', function (array $attributes) {
            return Theme::partial('shortcodes.featured-posts.admin', compact('attributes'));
        });
    }

    if (is_plugin_active('team')) {
        Shortcode::register('team', __('Team'), __('Team'), function (ShortcodeCompiler $shortcode) {
            $teamIds = Shortcode::fields()->getIds('team_ids', $shortcode);

            if (! $teamIds) {
                return null;
            }

            $teams = Team::query()
                ->whereIn('id', $teamIds)
                ->get();

            if ($teams->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.team.index', compact('shortcode', 'teams'));
        });

        Shortcode::setAdminConfig('team', function (array $attributes) {
            $teams = Team::query()
                ->wherePublished()
                ->latest()
                ->pluck('name', 'id');

            $teamIds = explode(',', Arr::get($attributes, 'team_ids', ''));

            return Theme::partial('shortcodes.team.admin', compact('attributes', 'teams', 'teamIds'));
        });
    }

    Shortcode::register('contact-box', __('Contact Box'), __('Contact Box'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.contact-box.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('contact-box', function (array $attributes) {
        return Theme::partial('shortcodes.contact-box.admin', compact('attributes'));
    });

    Shortcode::register('about', __('About'), __('About'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.about.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('about', function (array $attributes) {
        return Theme::partial('shortcodes.about.admin', compact('attributes'));
    });

    Shortcode::register('features', __('Features'), __('Features'), function (ShortcodeCompiler $shortcode) {
        $quantity = min((int) $shortcode->quantity, 5);

        return Theme::partial('shortcodes.features.index', compact('shortcode', 'quantity'));
    });

    Shortcode::setAdminConfig('features', function (array $attributes) {
        return Theme::partial('shortcodes.features.admin', compact('attributes'));
    });

    Shortcode::register('coming-soon', __('Coming Soon'), __('Coming Soon'), function (ShortcodeCompiler $shortcode) {
        Theme::asset()->container('footer')->usePath()->add('countdown-js', 'js/countdown.js');

        return Theme::partial('shortcodes.coming-soon.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('coming-soon', function (array $attributes) {
        return Theme::partial('shortcodes.coming-soon.admin', compact('attributes'));
    });

    Shortcode::register('shop-location', __('Shop Location'), __('Shop Location'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.shop-location.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('shop-location', function (array $attributes) {
        return Theme::partial('shortcodes.shop-location.admin', compact('attributes'));
    });

    Shortcode::register('services', __('Services'), __('Services'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.services.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('services', function (array $attributes) {
        return Theme::partial('shortcodes.services.admin', compact('attributes'));
    });

    Shortcode::register('brands', __('Brands'), __('Brands'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.brands.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('brands', function (array $attributes) {
        return Theme::partial('shortcodes.brands.admin', compact('attributes'));
    });

    if (is_plugin_active('testimonial')) {
        Shortcode::register('testimonials', __('Testimonials'), __('Testimonials'), function (ShortcodeCompiler $shortcode): string|null {
            $testimonials = Testimonial::query()
                ->wherePublished()
                ->limit((int)$shortcode->limit ?: 4)
                ->get();

            if ($testimonials->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.testimonials.index', compact('shortcode', 'testimonials'));
        });

        Shortcode::setAdminConfig('testimonials', function (array $attributes): string|null {
            return Theme::partial('shortcodes.testimonials.admin', compact('attributes'));
        });
    }

    Shortcode::register('reviews', __('Reviews'), __('Reviews'), function (ShortcodeCompiler $shortcode): string|null {
            
        $reviews = Review::query()
        ->where('status','published ')
        ->with(['product', 'product.slugable'])
        ->orderByDesc('ec_reviews.created_at')
        ->paginate(12);
            // dd($reviews);


            if ($reviews->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.reviews.index', compact('shortcode', 'reviews'));
        });
});
