<form
    class="shipment-create-panel"
    action="{{ $url }}"
>
    <div class="pd-all-20 pt10">
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding">
            <div class="flexbox-grid-form-item rps-no-pd-none-r">
                <div class="form-group mb-3">
                    <label class="text-title-field">{{ trans('plugins/ecommerce::shipping.warehouse') }}:</label>
                    <div class="ui-select-wrapper">
                        {!! Form::select(
                            'store_id',
                            $storeLocators->pluck('name', 'id')->all(),
                            $storeLocators->where('is_primary', true)->first() ? $storeLocators->where('is_primary', true)->first()->id : null,
                            [
                                'class' => 'ui-select',
                                'id' => 'store_id',
                            ],
                        ) !!}
                        <svg class="svg-next-icon svg-next-icon-size-16">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                            </svg>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flexbox-grid-form-item max-width-220-px">
                <div class="form-group mb-3">
                    <div class="form-group mb-3">
                        <label
                            class="text-title-field">{{ trans('plugins/ecommerce::shipping.weight_unit', ['unit' => ecommerce_weight_unit()]) }}:</label>
                        <input
                            class="next-input input-mask-number shipment-form-weight"
                            name="weight"
                            type="text"
                            value="{{ $weight }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="address-header p-b5">
            <div class="left">{{ trans('plugins/ecommerce::shipping.shipping_address') }}:</div>
            <div class="right"><a
                    class="hover-tooltip hover-underline color-blue btn-trigger-update-shipping-address"
                    href="#"
                >{{ trans('plugins/ecommerce::shipping.edit') }}</a></div>
        </div>
        <div style="clear:both;"></div>
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767 mb10">
            <div class="shipment-address-box-1 wrapword">@include('plugins/ecommerce::orders.shipping-address.line', ['address' => $order->address])</div>
        </div>
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767">
            <div class="flexbox-grid-form-item rps-no-pd-none-r">
                <div class="form-group mb-3">
                    <div class="">
                        <label class="text-title-field">
                            {{ trans('plugins/ecommerce::shipping.shipping_method') }}:
                        </label>
                    </div>
                    <div
                        class="user-control-combox-v3"
                        id="select-shipping-provider"
                    >
                        <div
                            class="flexbox-grid-default"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <div class="flexbox-content p-none-important">
                                <input
                                    class="input-hidden-shipping-method"
                                    name="method"
                                    type="hidden"
                                    value="{{ $order->shipping_method }}"
                                >
                                <input
                                    class="input-hidden-shipping-option"
                                    name="option"
                                    type="hidden"
                                    value="{{ $order->shipping_option }}"
                                >
                                <input
                                    class="next-input input-dropdown input-show-shipping-method"
                                    type="text"
                                    value="{{ $order->shipping_method_name }}"
                                    readonly="readonly"
                                    placeholder="{{ trans('plugins/ecommerce::shipping.select_shipping_method') }}"
                                >
                            </div>
                        </div>
                        <div class="dropdown-menu dropdown-carrier font-size-13px animate-scale-dropdown bg-white">
                            <div class="arrow-top-dropdown"></div>
                            <div>
                                <table class="table table-fix-header2 table-shipping-select-options">
                                    <thead>
                                        <tr>
                                            <th><b>{{ trans('plugins/ecommerce::shipping.packages') }}</b><i
                                                    style="display:block;font-size: xx-small; color: darkgoldenrod"
                                                ><span class="ws-nm">{{ trans('plugins/ecommerce::shipping.warehouse') }}
                                                        {{ get_ecommerce_setting('store_city') }},
                                                        {{ get_ecommerce_setting('store_state') }}</span></i></th>
                                            <th class="text-end">
                                                <b>{{ trans('plugins/ecommerce::shipping.shipping_fee_cod') }}</b><i
                                                    style="display:block;font-size: xx-small;"
                                                >{{ trans('plugins/ecommerce::shipping.fee') }}</i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shipping as $shippingKey => $shippingItem)
                                            @foreach ($shippingItem as $subShippingKey => $subShippingItem)
                                                <tr
                                                    class="clickable-row"
                                                    data-key="{{ $shippingKey }}"
                                                    data-option="{{ $subShippingKey }}"
                                                >
                                                    <td class="border-none pl25">
                                                        <span class="clearfix">
                                                            <span
                                                                class="ws-nm color--green border-none-b p-none-b">{{ $subShippingItem['name'] }}</span>
                                                        </span>
                                                    </td>
                                                    <td class="border-none text-end">
                                                        <span>{{ format_price($subShippingItem['price']) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="flexbox-grid-form flexbox-grid-form-item flexbox-grid-form-no-outside-padding rps-no-pd-none-l ps-relative max-width-220-px">
                <div class="flexbox-grid-form-item">
                    @if (is_plugin_active('payment') &&
                            $order->payment->payment_channel == \Botble\Payment\Enums\PaymentMethodEnum::COD &&
                            $order->payment->status !== \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED)
                        <div class="form-group mb-3">
                            <label
                                class="text-title-field">{{ trans('plugins/ecommerce::shipping.cod_amount') }}:</label>
                            <div class="next-input--stylized">
                                <span
                                    class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                                <input
                                    class="next-input next-input--invisible input-mask-number"
                                    name="cod_amount"
                                    data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}"
                                    data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                                    type="text"
                                    value="{{ format_price($order->amount, null, true) }}"
                                >
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding">
            <div class="flexbox-grid-form-item rps-no-pd-none-r">
                <div class="form-group mb-3">
                    <label class="text-title-field">{{ trans('plugins/ecommerce::shipping.note') }}:</label>
                    <textarea
                        class="ui-text-area textarea-auto-height"
                        name="note"
                        rows="1"
                    ></textarea>
                </div>
            </div>
        </div>
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding ps-relative">
            <div class="flexbox-grid-form-item d-none d-sm-flex"></div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="flexbox-grid-default flexbox-align-items-center">
            <div class="flexbox-auto-content text-start">
                <label class="next-label">

                    <input
                        name="send_mail"
                        type="checkbox"
                        value="1"
                        checked
                    >

                    <span
                        class="pre-line">{{ trans('plugins/ecommerce::shipping.send_confirmation_email_to_customer') }}</span>
                </label>
            </div>
            <div class="flexbox-auto-content">
                <button
                    class="btn btn-secondary btn-close-shipment-panel"
                    type="button"
                >{{ trans('plugins/ecommerce::shipping.cancel') }}</button>
                <button
                    class="btn btn-primary btn-create-shipment"
                    type="button"
                >{{ trans('plugins/ecommerce::shipping.finish') }}</button>
            </div>
        </div>
    </div>
</form>
