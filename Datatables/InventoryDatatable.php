<?php

namespace Modules\Inventory\Datatables;

use Utils;
use URL;
use Auth;
use App\Ninja\Datatables\EntityDatatable;

class InventoryDatatable extends EntityDatatable
{
    public $entityType = 'inventory';
    public $sortCol = 1;

    public function columns()
    {
        return [
            
            [
                'created_at',
                function ($model) {
                    return Utils::fromSqlDateTime($model->created_at);
                }
            ],
        ];
    }

    public function actions()
    {
        return [
            [
                mtrans('inventory', 'edit_inventory'),
                function ($model) {
                    return URL::to("inventory/{$model->public_id}/edit");
                },
                function ($model) {
                    return Auth::user()->can('editByOwner', ['inventory', $model->user_id]);
                }
            ],
        ];
    }

}
