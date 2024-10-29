<?php

namespace App\Repositories;

use App\Interfaces\DeliveryAreaRepositoryInterface;
use App\Models\DeliveryArea;

class DeliveryAreaRepository implements DeliveryAreaRepositoryInterface
{
    public function storeDeliveryArea(array $data)
    {
        return DeliveryArea::create($data);
    }

    public function updateDeliveryArea(array $data, $deliveryArea)
    {
        $deliveryArea->update($data);
    }

    public function destroyDeliveryArea($deliveryArea)
    {
        $deliveryArea->delete();
    }
}
