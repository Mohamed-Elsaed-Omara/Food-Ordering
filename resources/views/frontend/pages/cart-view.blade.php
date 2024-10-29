@extends('frontend.layouts.master')
@section('content')
    <!--=============================
                        BREADCRUMB START
                    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">home</a></li>
                        <li><a href="javascript:void(0)">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                        BREADCRUMB END
                    ==============================-->


    <!--============================
                        CART VIEW START
                    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="fp__pro_img">
                                            Image
                                        </th>

                                        <th class="fp__pro_name">
                                            details
                                        </th>

                                        <th class="fp__pro_status">
                                            price
                                        </th>

                                        <th class="fp__pro_select">
                                            quantity
                                        </th>

                                        <th class="fp__pro_tk">
                                            total
                                        </th>

                                        <th class="fp__pro_icon">
                                            <a class="clear_all" href="{{ route('cart.destroy') }}">clear all</a>
                                        </th>
                                    </tr>
                                    @forelse (Cart::content() as $product)
                                        <tr>
                                            <td class="fp__pro_img"><img
                                                    src="{{ asset($product->options->product_info['image']) }}"
                                                    alt="product" class="img-fluid w-100">
                                            </td>

                                            <td class="fp__pro_name">
                                                <a
                                                    href="{{ route('product.show', $product->options->product_info['slug'] ?? '#') }}">{{ $product->name }}</a>
                                                <span>{{ @$product->options->product_size['name'] }}
                                                    {{ @$product->options->product_size['price'] ? '(' . currencyPosition($product->options->product_size['price']) . ')' : '' }}</span>
                                                @foreach ($product->options->product_option as $option)
                                                    <p>{{ $option['name'] }}
                                                        ({{ currencyPosition($option['price']) }})
                                                    </p>
                                                @endforeach
                                            </td>

                                            <td class="fp__pro_status">
                                                <h6 class="price">{{ currencyPosition($product->price) }}</h6>
                                            </td>

                                            <td class="fp__pro_select">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-danger decrement"><i
                                                            class="fal fa-minus"></i></button>
                                                    <input type="text" name="quentity" id="quentity"
                                                        data-id="{{ $product->rowId }}" value="{{ $product->qty }}"
                                                        readonly>
                                                    <button class="btn btn-success increment"><i
                                                            class="fal fa-plus"></i></button>
                                                </div>
                                            </td>

                                            <td class="fp__pro_tk">
                                                <h6 class="product_cart_total">
                                                    {{ currencyPosition(productTotal($product->rowId)) }}</h6>
                                            </td>

                                            <td class="fp__pro_icon">
                                                <a href="#" class="remove_cart_product"
                                                    data-id="{{ $product->rowId }}"><i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center fp__pro_name "
                                                style="width: 100%;display: inline;  ">Cart is empty!</td>
                                        </tr>
                                    @endforelse



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="sub_total">{{ currencyPosition(calculateTotal()) }}</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        @if (isset(session()->get('coupon')['discount']))
                        <p>discount: <span id="discount">{{ currencyPosition(session()->get('coupon')['discount']) }}</span></p>
                        @else
                        <p>discount: <span id="discount">{{ currencyPosition(0) }}</span></p>
                        @endif
                        @if (isset(session()->get('coupon')['discount']))
                        <p class="total"><span>total:</span> <span id="final_total">{{ currencyPosition(calculateTotal() - session()->get('coupon')['discount']) }} </span></p>
                        @else
                        <p class="total"><span>total:</span> <span id="final_total">{{ currencyPosition(calculateTotal()) }} </span></p>
                        @endif
                        <form id="coupon_form" method="POST">
                            @csrf
                            <input type="text" id="coupon_code" name="code" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>

                        <div class="coupon_card">
                            @if (session()->has('coupon'))
                            <div class="card mt-2">
                                <div class="mt-3">
                                    <span><b>Applied Coupon: {{ session()->get('coupon')['code'] }}</b></span>
                                    <span>
                                        <button id="destroy_coupon"><i class="far fa-times"></i></button>
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <a class="common_btn" href="{{ route('checkout') }}">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                        CART VIEW END
                    ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            let subTotal = parseInt("{{ calculateTotal() }}");

            $('.increment').on('click', function(e) {
                e.preventDefault();
                let quentity = $(this).siblings('#quentity');
                let currentQuentity = Number(quentity.val());
                let rowId = quentity.data('id');

                quentity.val(currentQuentity + 1);

                cartQtyUpdate(rowId, quentity.val(), function(response) {
                    if (response.status === 'success') {
                        quentity.val(response.qty);
                        let productTotal = response.product_total;
                        quentity.closest('tr').find('.product_cart_total')
                            .text("{{ currencyPosition(':productTotal') }}"
                                .replace(':productTotal', productTotal));
                        subTotal = response.sub_total;
                        $('#sub_total').text("{{ currencyPosition(':subTotal') }}".replace(':subTotal', subTotal));
                        $('#final_total').text("{{ currencyPosition(':response.grand_cart_total') }}".replace(':response.grand_cart_total', response.grand_cart_total));
                    } else if (response.status === 'error') {
                        quentity.val(response.qty);
                        toastr.error(response.message);
                    }
                });
            });

            $('.decrement').on('click', function(e) {
                e.preventDefault();
                let quentity = $(this).siblings('#quentity');
                let currentQuentity = Number(quentity.val());
                let rowId = quentity.data('id');


                if (currentQuentity > 1) {
                    quentity.val(currentQuentity - 1);

                    cartQtyUpdate(rowId, quentity.val(), function(response) {
                        if (response.status === 'success') {

                            quentity.val(response.qty);
                            let productTotal = response.product_total;
                            quentity.closest('tr').find('.product_cart_total').text(
                                "{{ currencyPosition(':productTotal') }}".replace(
                                    ':productTotal',
                                    productTotal));
                            subTotal = response.sub_total;
                            $('#sub_total').text("{{ currencyPosition(':subTotal') }}".replace(':subTotal', subTotal));
                            $('#final_total').text("{{ currencyPosition(':response.grand_cart_total') }}".replace(':response.grand_cart_total', response.grand_cart_total));
                        } else if (response.status === 'error') {
                            quentity.val(response.qty);
                            toastr.error(response.message);
                        }
                    });

                }
            });


            function cartQtyUpdate(rowId, qty, callback) {

                $.ajax({
                    method: 'POST',
                    url: '{{ route('cart.quentity-update') }}',
                    data: {
                        //csrf
                        '_token': '{{ csrf_token() }}',
                        'rowId': rowId,
                        'qty': qty
                    },
                    beforeSend: function() {
                        $('.overlay-container').removeClass('d-none');
                        $('.overlay').addClass('active');
                    },
                    success: function(response) {
                        if (callback && typeof callback === 'function') {
                            callback(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    }
                });
            }

            $('.remove_cart_product').on('click', function(e) {
                e.preventDefault();
                let rowId = $(this).data('id');
                removeCartProduct(rowId);
                $(this).closest('tr').remove();
            })

            function removeCartProduct(rowId) {
                $.ajax({
                    method: 'get',
                    url: '{{ route('cart-product-remove', ':rowId') }}'.replace(":rowId", rowId),
                    beforeSend: function() {
                        $('.overlay-container').removeClass('d-none');
                        $('.overlay').addClass('active');
                    },
                    success: function(response) {
                        subTotal = response.sub_total;
                        $('#sub_total').text("{{ currencyPosition(':subTotal') }}"
                        .replace(':subTotal', subTotal));
                        $('#final_total').text("{{ currencyPosition(':response.grand_cart_total') }}".replace(':response.grand_cart_total', response.grand_cart_total));
                        updateSidebarCart();
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    }
                });
            }

            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();
                let couponCode = $('#coupon_code').val();

                couponApply(couponCode, subTotal);

            });

            function couponApply(code, subtotal) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('coupon.apply') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        code: code,
                        subtotal: subtotal
                    },
                    beforeSend: function() {
                        $('.overlay-container').removeClass('d-none');
                        $('.overlay').addClass('active');
                    },
                    success: function(response) {
                        $('#coupon_code').val("")
                        let discount = response.discount;
                        let finalTotal = response.finalTotal;
                        $('#discount').text("{{ currencyPosition(':discount') }}".replace(':discount',
                            discount));
                        $('#final_total').text("{{ currencyPosition(':finalTotal') }}".replace(
                            ':finalTotal', finalTotal));

                        $couponCartHtml = `<div class="card mt-2">
                                <div class="mt-3">
                                    <span><b>Applied Coupon: ${response.coupon_code}</b></span>
                                    <span>
                                        <button id="destroy_coupon"><i class="far fa-times"></i></button>
                                    </span>
                                </div>
                            </div>`;
                        $('.coupon_card').html($couponCartHtml);
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    }
                })
            }

            $(document).on('click',"#destroy_coupon",function(e){
                e.preventDefault();
                distroyCoupon();
            });

            function distroyCoupon(){
                $.ajax({
                    method: 'get',
                    url: '{{ route("destroy-coupon") }}',
                    beforeSend: function(){
                        $('.overlay-container').removeClass('d-none');
                        $('.overlay').addClass('active');
                    },
                    success: function(response){
                        $('.coupon_card').html('');
                        $('#discount').text("{{ currencyPosition(0) }}")
                        $('#final_total').text("{{ currencyPosition(':response.grand_cart_total') }}".replace(':response.grand_cart_total', response.grand_cart_total));
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function(){
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    }
                })
            }

        })
    </script>
@endpush
