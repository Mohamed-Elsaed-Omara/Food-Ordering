<input type="hidden"  value="{{ calculateTotal() }}" id="cart_total">
<input type="hidden"  value="{{ count(Cart::content()) }}" id="cart_product_count">

@foreach (Cart::content() as $product)
    <li>
        <div class="menu_cart_img">
            <img src="{{ asset(optional($product->options->product_info)['image']) }}" alt="menu"
                class="img-fluid w-100">
        </div>
        <div class="menu_cart_text">
            <a class="title"
                href="{{ route('product.show', optional($product->options->product_info)['slug'] ?? '#') }}">
                {{ $product->name }}
            </a>
            <p class="size">Qty: {{ $product->qty }}</p>
            <!-- استخدام array_get للوصول إلى القيم بأمان -->
            <p class="size">{{ @$product->options->product_size['name'] }} {{ @$product->options->product_size
                        ['price'] ? '(' . currencyPosition($product->options->product_size['price']) . ')' : '' }}</p>
            @foreach ($product->options->product_option as $option)
                <span class="extra">{{ $option['name'] }}
                    ({{ currencyPosition($option['price']) }})
                </span>
            @endforeach
            <p class="price">{{ currencyPosition($product->price) }}</p>
        </div>
        <span class="del_icon" onclick="removeProductFromSidebar('{{ $product->rowId }}')"><i class="fal fa-times"></i></span>
    </li>
@endforeach
