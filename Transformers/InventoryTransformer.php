<?php

namespace Modules\Inventory\Transformers;

use Modules\Inventory\Models\Inventory;
use App\Ninja\Transformers\EntityTransformer;

/**
 * @SWG\Definition(definition="Inventory", @SWG\Xml(name="Inventory"))
 */

class InventoryTransformer extends EntityTransformer
{
    /**
    * @SWG\Property(property="id", type="integer", example=1, readOnly=true)
    * @SWG\Property(property="user_id", type="integer", example=1)
    * @SWG\Property(property="account_key", type="string", example="123456")
    * @SWG\Property(property="updated_at", type="integer", example=1451160233, readOnly=true)
    * @SWG\Property(property="archived_at", type="integer", example=1451160233, readOnly=true)
    */

    /**
     * @param Inventory $inventory
     * @return array
     */
    public function transform(Inventory $inventory)
    {
        return array_merge($this->getDefaults($inventory), [
            
            'id' => (int) $inventory->public_id,
            'updated_at' => $this->getTimestamp($inventory->updated_at),
            'archived_at' => $this->getTimestamp($inventory->deleted_at),
        ]);
    }
}
