<?php

namespace App\Interfaces;

interface CouponRepositoryInterface
{
    public function storeCoupon(array $date);
    public function updateCoupon($coupon, array $date);
    public function destroyCoupon($coupon);
}
