<?php

namespace Modules\Inventory\Repositories;

use DB;
use Modules\Inventory\Models\Inventory;
use App\Ninja\Repositories\BaseRepository;
//use App\Events\InventoryWasCreated;
//use App\Events\InventoryWasUpdated;

class InventoryRepository extends BaseRepository
{
    public function getClassName()
    {
        return 'Modules\Inventory\Models\Inventory';
    }

    public function all()
    {
        return Inventory::scope()
                ->orderBy('created_at', 'desc')
                ->withTrashed();
    }

    public function find($filter = null, $userId = false)
    {
        $query = DB::table('inventory')
                    ->where('inventory.account_id', '=', \Auth::user()->account_id)
                    ->select(
                        
                        'inventory.public_id',
                        'inventory.deleted_at',
                        'inventory.created_at',
                        'inventory.is_deleted',
                        'inventory.user_id'
                    );

        $this->applyFilters($query, 'inventory');

        if ($userId) {
            $query->where('clients.user_id', '=', $userId);
        }

        /*
        if ($filter) {
            $query->where();
        }
        */

        return $query;
    }

    public function save($data, $inventory = null)
    {
        $entity = $inventory ?: Inventory::createNew();

        $entity->fill($data);
        $entity->save();

        /*
        if (!$publicId || intval($publicId) < 0) {
            event(new ClientWasCreated($client));
        } else {
            event(new ClientWasUpdated($client));
        }
        */

        return $entity;
    }

}
