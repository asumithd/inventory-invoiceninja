<?php

namespace Modules\Inventory\;

use App\Providers\AuthServiceProvider;

class InventoryAuthProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Modules\Inventory\Models\Inventory::class => \Modules\Inventory\Policies\InventoryPolicy::class,
    ];
}
