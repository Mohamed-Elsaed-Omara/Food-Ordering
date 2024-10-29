<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Cart;
use Flasher\Laravel\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index()
    {

        return view('frontend.pages.cart-view');
    }
    public function addToCart(Request $request)
    {
        $product = Product::with(['sizes', 'options'])->findOrFail($request->product_id);
        if ($product->quantity < $request->quentity) {
            throw ValidationException::withMessages(['Quantity Not Available']);
        }
        try {
            $productSize = $product->sizes->where('id', $request->size)->first();
            $productOption = $product->options->whereIn('id', $request->option);
            $options = [
                'product_size' => [],
                'product_option' => [],
                'product_info' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug,
                ]
            ];

            if ($productSize !== null) {
                $options['product_size'] = [
                    'id' => $productSize?->id,
                    'name' => $productSize?->size,
                    'price' => $productSize?->price,
                ];
            }
            foreach ($productOption as $option) {
                $options['product_option'][] = [
                    'id' => $option->id,
                    'name' => $option->name,
                    'price' => $option->price,
                ];
            }

            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quentity,
                'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
                'weight' => 0,
                'options' => $options,
            ]);

            return response(['status' => 'success', 'message' => 'Product added successfully!', 200]);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!', 500]);
        }
    }

    public function modelAddToCart()
    {
        return view('frontend.layouts.ajax-request.sidebar-cart-item')->render();
    }

    public function cartProductRemove($rowId)
    {
        try {
            Cart::remove($rowId);
            return response([
                'status' => 'success',
                'sub_total' => calculateTotal(),
                'grand_cart_total' => grandCartTotal(),
                'message' => 'Product removed successfully!',
                200
            ]);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!', 500]);
        }
    }

    function cartQtyUpdate(Request $request)
    {
        $cartItem = Cart::get($request->rowId);
        $product = Product::findOrFail($cartItem->id);

        if ($product->quantity < $request->qty) {
            return response([
                'status' => 'error',
                'message' => 'Qty updated failed',
                'qty' => $cartItem->qty
            ]);
        }
        try {
            $cart = Cart::update($request->rowId, $request->qty);
            return response(
                [
                    'status' => 'success',
                    'message' => 'Qty updated successfully',
                    'product_total' => productTotal($request->rowId),
                    'sub_total' => calculateTotal(),
                    'grand_cart_total' => grandCartTotal(),
                    'qty' => $cart->qty
                ],
                200
            );
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Qty updated failed'], 500);
        }
    }

    function cartDestroy()
    {
        Cart::destroy();
        session()->forget('coupon');
        return redirect()->back();
    }

    function couponApply(Request $request)
    {

        $subTotal = $request->subtotal;
        $code = $request->code;
        $coupon = Coupon::where('code', $request->code,)->first();

        if (!$coupon) {
            return response(['message' => 'Invalid Coupon Code.'], 422);
        }
        if ($coupon->quantity <= 0) {
            return response(['message' => 'Coupon has been fully redeemed.'], 422);
        }
        if ($coupon->expiry_date < now()) {
            return response(['message' => 'Coupon has expired.'], 422);
        }

        if ($coupon->discount_type === 'percent') {
            $discount = number_format(($subTotal * ($coupon->discount / 100)), 2);
        } elseif ($coupon->discount_type === 'fixed') {
            $discount = number_format($coupon->discount, 2);
        }

        $finalTotal = $subTotal - $discount;

        session()->put('coupon', ['code' => $code, 'discount' => $discount]);
        return response([
            'message' => 'Coupon Applied Successfully.',
            'discount' => $discount,
            'finalTotal' => $finalTotal,
            'coupon_code' => $code
        ]);
    }

    public function destroyCoupon()
    {
        try{
            session()->forget('coupon');

            return response([
                'message' => 'Coupon Removed!',
                'grand_cart_total' => grandCartTotal()
            ]);
        }catch(\Exception $e){
            logger($e);
            return response(['message' => 'Something went wrong!']);
        }
    }
}
