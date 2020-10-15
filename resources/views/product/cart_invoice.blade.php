                                    <div class="col-xl-12">

                                        <div id="cartAmountWrap" class="">

                                            <div id="cartAmount" class="row">
                                                <div id="cartAmount_label" class="col-xl-6"><label>@lang('shop.my_cart_amount'):</label></div>
                                                <div id="cartAmount_txt" class="col-xl-6 text-right"><span>{{ number_format($amount,0,"",".") }}</span> {{ setting('shop.valuta') }}</div>
                                            </div>

                                            <div id="cartDiscount" class="row">
                                                <div id="cartDiscount_label" class="col-xl-6"><label>@lang('shop.my_cart_discount'):</label></div>
                                                <div id="cartDiscount_txt" class="col-xl-6 text-right"><span>{{ $discount }}</span>%</div>
                                                <input type="hidden" name="discount" value="{{ $discount }}">
                                            </div>

                                            <div id="cartShipping" class="row">
                                                <div id="cartShipping_label" class="col-xl-4"><label>@lang('shop.my_cart_shipping'):</label></div>
                                                <div id="cartShipping_txt" class="col-xl-8 small text-right">{{ setting('shop.shop_delivery_note') }}</div>
                                            </div>

                                                @php
                                                    $total = $total - ($total/100)*$discount;
                                                @endphp

                                            <div id="cartTotal" class="row">
                                                <div id="cartTotal_label" class="col-xl-6">
                                                    <label>@lang('shop.my_cart_amount_total'):</label>
                                                    <span>(@lang('shop.my_cart_amount_total_vat'))</span>
                                                </div>
                                                <div id="cartTotal_txt" class="col-xl-6 text-right"><label>{{ number_format($total,0,"",".") }}</label> {{ setting('shop.valuta') }}</div>
                                            </div>

                                        </div>

                                    </div>