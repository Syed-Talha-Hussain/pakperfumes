<?php

namespace Botble\SalePopup\Http\Requests;

use Botble\Support\Http\Requests\Request;

class SalePopupSettingsRequest extends Request
{
    public function rules(): array
    {
        return [
            'enabled' => ['sometimes', 'required', 'boolean'],
            'collection_id' => ['sometimes', 'required', 'string'],
            'purchased_text' => ['required', 'string'],
            'verified_text' => ['required', 'string'],
            'quick_view_text' => ['required', 'string'],
            'list_users_purchased' => ['required', 'string'],
            'show_time_ago_suggest' => ['sometimes', 'required', 'boolean'],
            'list_sale_time' => ['required', 'string'],
            'limit_products' => ['sometimes', 'required', 'numeric'],
            'show_verified' => ['sometimes', 'required', 'boolean'],
            'show_close_button' => ['sometimes', 'required', 'boolean'],
            'show_quick_view_button' => ['sometimes', 'required', 'boolean'],
            'display_pages' => ['sometimes', 'required', 'array'],
        ];
    }
}
