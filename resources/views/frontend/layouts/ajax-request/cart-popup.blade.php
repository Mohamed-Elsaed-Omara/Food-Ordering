<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal fa-times"></i></button>
<form action="{{ route('add-to-cart') }}" id="model-add-to-cart" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="fp__cart_popup_img">
        <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}" class="img-fluid w-100">
    </div>
    <div class="fp__cart_popup_text">
        <a href="{{ route('product.show', $product->slug) }}" class="title">{{ $product->name }}</a>
        <p class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
            <span>(201)</span>
        </p>
        <h4 class="price">
            @if ($product->offer_price > 0)
                <input type="hidden" name="base_price" value="{{ $product->offer_price }}">
                {{ currencyPosition($product->offer_price) }}
                <del>{{ currencyPosition($product->price) }}</del>
            @else
                <input type="hidden" name="base_price" value="{{ $product->price }}">
                {{ currencyPosition($product->price) }}
            @endif
        </h4>
        @if ($productSize = $product->sizes()->exists())
            <div class="details_size">
                <h5>select size</h5>
                @foreach ($product->sizes as $size)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" data-price="{{ $size->price }}"
                            value="{{ $size->id }}" name="size" id="{{ $size->size }}">
                        <label class="form-check-label" for="{{ $size->size }}">
                            {{ $size->size }} <span>+ {{ currencyPosition($size->price) }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($product->options()->exists())
            <div class="details_extra_item">
                <h5>select option <span>(optional)</span></h5>
                @foreach ($product->options as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $option->id }}"
                            id="{{ $option->id }}" data-price="{{ $option->price }}" name="option[]">
                        <label class="form-check-label" for="{{ $option->id }}">
                            {{ $option->name }}
                            <span>+ {{ currencyPosition($option->price) }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="details_quentity">
            <h5>select quentity</h5>
            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                <div class="quentity_btn">
                    <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                    <input type="text" placeholder="1" name="quentity" id="quentity" value="1" readonly>
                    <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
                </div>
                @if ($product->offer_price > 0)
                    <h3 id="total_price">{{ currencyPosition($product->offer_price) }}</h3>
                @else
                    <h3 id="total_price">{{ currencyPosition($product->price) }}</h3>
                @endif
            </div>
        </div>
        <ul class="details_button_area d-flex flex-wrap">
            @if ($product->quantity === 0)
            <li><button type="button" class="common_btn bg-danger">out of stock</button></li>
            @else
            <li><button type="submit" class="common_btn modal-add-to-cart">add to cart</button></li>
            @endif
        </ul>
    </div>
</form>

<script>
    $(document).ready(function() {

        $('.increment').on('click', function(e) {
            e.preventDefault();
            let quentity = $('#quentity');
            let currentQuentity = Number(quentity.val());
            quentity.val(currentQuentity + 1);
            updateTotalPrice();
        });

        $('.decrement').on('click', function(e) {
            e.preventDefault();
            let quentity = $('#quentity');
            let currentQuentity = Number(quentity.val());
            if (currentQuentity > 1) {

                quentity.val(currentQuentity - 1);
                updateTotalPrice();
            }
        });

        // define variables
        const $sizeInput = $('input[name="size"]');
        const $optionInput = $('input[name="option[]"]');
        const $basePriceInput = $('input[name="base_price"]');
        const $totalPrice = $('#total_price');
        const $quentity = $('#quentity');

        // add event listeners
        $sizeInput.add($optionInput).on('change', updateTotalPrice);

        function updateTotalPrice() {
            // calculate base price
            let basePrice = Number($basePriceInput.val()) || 0;

            // calculate size price
            let sizePrice = Number($sizeInput.filter(':checked').data('price')) || 0;

            // calculate option price
            let optionPrice = 0;
            $optionInput.filter(':checked').each(function() {
                optionPrice += Number($(this).data('price')) || 0;
            });

            // calculate total price
            let totalPrice = (basePrice + sizePrice + optionPrice) * Number($quentity.val());

            // update total price
            $totalPrice.text("{{ config('settings.site_currency_icon') }}" + totalPrice.toFixed(2));
        }

        $('#model-add-to-cart').on('submit', function(e) {
            e.preventDefault();

            //validation select size
            if($sizeInput.length > 0){
                if($sizeInput.filter(':checked').val() === undefined){
                    toastr.error('Please select size');
                    return false;
                }
            }

            let url = $(this).attr('action');
            let formData = new FormData(this);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false, // لتعطيل المعالجة التلقائية للبيانات
                contentType: false, // لتعطيل نوع المحتوى الافتراضي
                beforeSend: function(){
                    $('.modal-add-to-cart').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>Loading...');
                },
                success: function(response) {
                    if (response.status == 'success') {
                        updateSidebarCart();
                        toastr.success(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.responseJSON.message;
                    toastr.error(errorMessage);
                },
                complete: function() {
                    $('.modal-add-to-cart').text('Add to cart');
                }
            });
        });
    });
</script>
