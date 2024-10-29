<?php

namespace App\Interfaces;


Interface DeliveryAreaRepositoryInterface
{
    //store delivery area
    public function storeDeliveryArea(array $data);

    //update delivery area
    public function updateDeliveryArea(array $data, $deliveryArea);

    //destroy delivery area
    public function destroyDeliveryArea($deliveryArea);
}
