<?php

namespace Modules\Inventory\Http\ApiControllers;

use App\Http\Controllers\BaseAPIController;
use Modules\Inventory\Repositories\InventoryRepository;
use Modules\Inventory\Http\Requests\InventoryRequest;
use Modules\Inventory\Http\Requests\CreateInventoryRequest;
use Modules\Inventory\Http\Requests\UpdateInventoryRequest;

class InventoryApiController extends BaseAPIController
{
    protected $InventoryRepo;
    protected $entityType = 'inventory';

    public function __construct(InventoryRepository $inventoryRepo)
    {
        parent::__construct();

        $this->inventoryRepo = $inventoryRepo;
    }

    /**
     * @SWG\Get(
     *   path="/inventory",
     *   summary="List inventory",
     *   operationId="listInventorys",
     *   tags={"inventory"},
     *   @SWG\Response(
     *     response=200,
     *     description="A list of inventory",
     *      @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Inventory"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function index()
    {
        $data = $this->inventoryRepo->all();

        return $this->listResponse($data);
    }

    /**
     * @SWG\Get(
     *   path="/inventory/{inventory_id}",
     *   summary="Individual Inventory",
     *   operationId="getInventory",
     *   tags={"inventory"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="inventory_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A single inventory",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Inventory"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function show(InventoryRequest $request)
    {
        return $this->itemResponse($request->entity());
    }




    /**
     * @SWG\Post(
     *   path="/inventory",
     *   summary="Create a inventory",
     *   operationId="createInventory",
     *   tags={"inventory"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="inventory",
     *     @SWG\Schema(ref="#/definitions/Inventory")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="New inventory",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Inventory"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function store(CreateInventoryRequest $request)
    {
        $inventory = $this->inventoryRepo->save($request->input());

        return $this->itemResponse($inventory);
    }

    /**
     * @SWG\Put(
     *   path="/inventory/{inventory_id}",
     *   summary="Update a inventory",
     *   operationId="updateInventory",
     *   tags={"inventory"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="inventory_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="inventory",
     *     @SWG\Schema(ref="#/definitions/Inventory")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Updated inventory",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Inventory"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function update(UpdateInventoryRequest $request, $publicId)
    {
        if ($request->action) {
            return $this->handleAction($request);
        }

        $inventory = $this->inventoryRepo->save($request->input(), $request->entity());

        return $this->itemResponse($inventory);
    }


    /**
     * @SWG\Delete(
     *   path="/inventory/{inventory_id}",
     *   summary="Delete a inventory",
     *   operationId="deleteInventory",
     *   tags={"inventory"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="inventory_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Deleted inventory",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Inventory"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function destroy(UpdateInventoryRequest $request)
    {
        $inventory = $request->entity();

        $this->inventoryRepo->delete($inventory);

        return $this->itemResponse($inventory);
    }

}
