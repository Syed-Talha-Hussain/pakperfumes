<?php

namespace Botble\SalePopup\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SalePopup\Http\Requests\SalePopupSettingsRequest;
use Botble\SalePopup\Support\SalePopupHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class SettingController extends BaseController
{
    public function index(SalePopupHelper $salePopupHelper): View
    {
        PageTitle::setTitle(trans('plugins/sale-popup::sale-popup.name'));

        return view('plugins/sale-popup::settings', compact('salePopupHelper'));
    }

    public function update(
        SalePopupSettingsRequest $request,
        BaseHttpResponse $response,
        SalePopupHelper $salePopupHelper
    ): BaseHttpResponse {
        $salePopupHelper->saveSettings(Arr::only($request->validated(), $salePopupHelper->settingKeys()));

        return $response
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
