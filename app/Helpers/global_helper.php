<?php

//Create unique slug

if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name): string
    {
        $modelClass = "App\\Models\\$model";

        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model $model not found.");
        }

        $slug = Str::slug($name);
        $count = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }
        return $slug;
    }
}

if (!function_exists('currencyPosition')) {
    function currencyPosition($price): string
    {
        if (config('settings.site_currency_icon_position') === 'left') {
            return config('settings.site_currency_icon') . $price;
        } else {
            return $price . config('settings.site_currency_icon');
        }
    }
}

if (!function_exists('calculateTotal')) {
    function calculateTotal()
    {
        $total = 0;
        $priceSize = 0;
        $priceOption = 0;

        foreach (Cart::content() as $product) {
            $productPrice = $product->price;
            $priceSize = $product->options->product_size['price'] ?? 0;

            foreach ($product->options->product_option as $option) {
                $priceOption += $option['price'] ?? 0;
            }
            $total += ($priceSize + $priceOption + $productPrice) * $product->qty;
        }
        return $total;
    }
}

if (!function_exists('productTotal')) {
    function productTotal($rowId)
    {
        $total = 0;
        $priceOption = 0;
        $product = Cart::get($rowId);
        $productPrice = $product->price;
        $priceSize = $product->options->product_size['price'] ?? 0;
        foreach ($product->options->product_option as $option) {
            $priceOption += $option['price'] ?? 0;
        }
        $total += ($priceSize + $priceOption + $productPrice) * $product->qty;

        return $total;
    }
}

if(!function_exists('grandCartTotal')){
    function grandCartTotal($delivery = 0)
    {
        $cartTotal = calculateTotal();
        $total = 0;

        if(session()->has('coupon')){
            $total = ($cartTotal + $delivery) - session()->get('coupon')['discount'];
            return $total;
        }else{
            return $cartTotal + $delivery;
        }
    }
}

if(!function_exists('generateInvoiceId')){
    function generateInvoiceId()
    {
        $randomNumber = rand(1, 999999);
        $currentDateTime = now();
        $invoiceId = $randomNumber . $currentDateTime->format('yd').$currentDateTime->format('s');

        return $invoiceId;

    }
}
