<?php

namespace Botble\SalePopup\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Theme\Facades\Theme;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SalePopupServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/sale-popup')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->publishAssets()
            ->loadRoutes();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-ecommerce-sale-popup-settings',
                'priority' => 995,
                'parent_id' => 'cms-plugins-ecommerce',
                'name' => 'plugins/sale-popup::sale-popup.name',
                'icon' => 'fas fa-cogs',
                'url' => route('sale-popup.settings'),
                'permissions' => ['sale-popup.settings'],
            ]);

            if (
                defined('THEME_FRONT_FOOTER') &&
                setting('sale_popup_enabled', 1) &&
                in_array(Route::currentRouteName(), json_decode(setting('sale_popup_display_pages', '["public.index"]'), true))
            ) {
                Theme::asset()
                    ->usePath(false)
                    ->add(
                        'sale-popup-css',
                        asset('vendor/core/plugins/sale-popup/css/sale-popup.css'),
                        [],
                        [],
                        '1.0.0'
                    );

                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add(
                        'sale-popup-js',
                        asset('vendor/core/plugins/sale-popup/js/sale-popup.js'),
                        ['jquery'],
                        [],
                        '1.0.0'
                    );

                add_filter(
                    THEME_FRONT_FOOTER,
                    fn (string|null $html) => $html . view('plugins/sale-popup::front')->render(),
                    1457
                );
            }
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
