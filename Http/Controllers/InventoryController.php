<?php

namespace Modules\Inventory\Http\Controllers;

use Auth;
use App\Http\Controllers\BaseController;
use App\Services\DatatableService;
use Modules\Inventory\Datatables\InventoryDatatable;
use Modules\Inventory\Repositories\InventoryRepository;
use Modules\Inventory\Http\Requests\InventoryRequest;
use Modules\Inventory\Http\Requests\CreateInventoryRequest;
use Modules\Inventory\Http\Requests\UpdateInventoryRequest;

class InventoryController extends BaseController
{
    protected $InventoryRepo;
    //protected $entityType = 'inventory';

    public function __construct(InventoryRepository $inventoryRepo)
    {
        //parent::__construct();

        $this->inventoryRepo = $inventoryRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('list_wrapper', [
            'entityType' => 'inventory',
            'datatable' => new InventoryDatatable(),
            'title' => mtrans('inventory', 'inventory_list'),
        ]);
    }

    public function datatable(DatatableService $datatableService)
    {
        $search = request()->input('sSearch');
        $userId = Auth::user()->filterId();

        $datatable = new InventoryDatatable();
        $query = $this->inventoryRepo->find($search, $userId);

        return $datatableService->createDatatable($datatable, $query);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(InventoryRequest $request)
    {
        $data = [
            'inventory' => null,
            'method' => 'POST',
            'url' => 'inventory',
            'title' => mtrans('inventory', 'new_inventory'),
        ];

        return view('inventory::edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CreateInventoryRequest $request)
    {
        $inventory = $this->inventoryRepo->save($request->input());

        return redirect()->to($inventory->present()->editUrl)
            ->with('message', mtrans('inventory', 'created_inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(InventoryRequest $request)
    {
        $inventory = $request->entity();

        $data = [
            'inventory' => $inventory,
            'method' => 'PUT',
            'url' => 'inventory/' . $inventory->public_id,
            'title' => mtrans('inventory', 'edit_inventory'),
        ];

        return view('inventory::edit', $data);
    }

    /**
     * Show the form for editing a resource.
     * @return Response
     */
    public function show(InventoryRequest $request)
    {
        return redirect()->to("inventory/{$request->inventory}/edit");
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateInventoryRequest $request)
    {
        $inventory = $this->inventoryRepo->save($request->input(), $request->entity());

        return redirect()->to($inventory->present()->editUrl)
            ->with('message', mtrans('inventory', 'updated_inventory'));
    }

    /**
     * Update multiple resources
     */
    public function bulk()
    {
        $action = request()->input('action');
        $ids = request()->input('public_id') ?: request()->input('ids');
        $count = $this->inventoryRepo->bulk($ids, $action);

        return redirect()->to('inventory')
            ->with('message', mtrans('inventory', $action . '_inventory_complete'));
    }
}
