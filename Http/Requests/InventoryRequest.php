<?php

namespace Modules\Inventory\Http\Requests;

use App\Http\Requests\EntityRequest;

class InventoryRequest extends EntityRequest
{
    protected $entityType = 'inventory';
}
