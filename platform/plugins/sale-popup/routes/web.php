<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\SalePopup\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'sale-popup', 'as' => 'sale-popup.'], function () {
            Route::get('settings', [
                'as' => 'settings',
                'uses' => 'SettingController@index',
                'permission' => 'sale-popup.settings',
            ]);

            Route::post('settings', [
                'as' => 'settings',
                'uses' => 'SettingController@update',
                'permission' => 'sale-popup.settings',
            ]);
        });
    });

    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('ajax/sale-popup/products', 'SalePopupController@ajaxSalePopup')
            ->name('public.ajax.sale-popup');
    });
});
