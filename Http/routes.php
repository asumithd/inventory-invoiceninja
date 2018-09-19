<?php

Route::group(['middleware' => ['web', 'lookup:user', 'auth:user'], 'namespace' => 'Modules\Inventory\Http\Controllers'], function()
{
    Route::resource('inventory', 'InventoryController');
    Route::post('inventory/bulk', 'InventoryController@bulk');
    Route::get('api/inventory', 'InventoryController@datatable');
});

Route::group(['middleware' => 'api', 'namespace' => 'Modules\Inventory\Http\ApiControllers', 'prefix' => 'api/v1'], function()
{
    Route::resource('inventory', 'InventoryApiController');
});
