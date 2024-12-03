<?php

namespace Botble\SalePopup\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Language\Facades\Language;
use Botble\Setting\Facades\Setting;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter('setting_sale_popup_meta_boxes', function (string|null $data, array $params = []) {
            $languages = Language::getActiveLanguage(['lang_id', 'lang_name', 'lang_code', 'lang_flag']);

            if ($languages->count() < 2) {
                return $data;
            }

            return $data . view('plugins/language::partials.admin-list-language-chooser', [
                    'route' => 'sale-popup.settings',
                    'params' => $params,
                    'languages' => $languages,
                ])->render();
        });

        add_filter('sale_popup_setting_key', function (string $key): string {
            $currentLocale = is_in_admin(true) ? Language::getCurrentAdminLocale() : Language::getCurrentLocale();
            $locale = $currentLocale !== Language::getDefaultLocale() ? $currentLocale : null;

            if ($locale && in_array($locale, array_keys(Language::getSupportedLocales()))) {
                $key = "$key-$locale";

                return Setting::has("$key-$locale") ? "$key-$locale" : $key;
            }

            return $key;
        }, 55);
    }
}
