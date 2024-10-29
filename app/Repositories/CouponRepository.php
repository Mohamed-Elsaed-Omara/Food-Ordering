<?php

namespace App\Repositories;

use App\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;

class CouponRepository implements CouponRepositoryInterface
{
    public function storeCoupon(array $date)
    {
        return Coupon::create($date);
    }

    public function updateCoupon($coupon, array $date)
    {
        $coupon->update($date);
    }

    public function destroyCoupon($coupon)
    {
        $coupon->delete();
    }
}
