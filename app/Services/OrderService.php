<?php

Namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Cart;


class OrderService{
    function createOrder()
    {
        try {

            $order = new Order();
            $order->invoice_id = generateInvoiceId();
            $order->user_id = auth()->user()->id;
            $order->address = session()->get('address');
            $order->discount = session()->get('coupon')['discount'] ?? 0;
            $order->delivery_charge = session()->get('delivery_fee') ?? 0;
            $order->subtotal = calculateTotal();
            $order->grand_total = grandCartTotal(session()->get('delivery_fee'));
            $order->product_qty = Cart::content()->count();
            $order->payment_method = null;
            $order->payment_status = 'pending';
            $order->payment_approve_date = null;
            $order->transaction_id = null;
            $order->coupon_info = json_encode(session()->get('coupon')) ;
            $order->currency_name = null;
            $order->order_status = 'pending';
            $order->save();

            foreach(Cart::content() as $product){
                $productItem = new OrderItem();
                $productItem->order_id = $order->id;
                $productItem->product_id = $product->id;
                $productItem->product_name = $product->name;
                $productItem->unit_price = $product->price;
                $productItem->qty = $product->qty;
                $productItem->product_size = json_encode($product->options->product_size);
                $productItem->product_option = json_encode($product->options->product_option);
                $productItem->save();
            }
            return true;
        }catch(\Exception $e){
            logger($e);
            return false;
        }
    }
}
