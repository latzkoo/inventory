<?php

namespace App\Http\Controllers;

use App\Model\Inventory;
use App\Model\Meta;
use App\Rules\InventoryRule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InventoryController extends Controller
{
    private $inventory;
    private $messages = [
        'raktarnev.unique' => 'A megadott névvel már létezik raktár!'
    ];

    /**
     * InventoryController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->inventory = new Inventory();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function get(Request $request)
	{
	    $this->data["meta"] = new Meta();
	    $this->data["inventories"] = $this->inventory->getList($request);

		return view('inventory.list', $this->data);
	}

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->data["meta"] = new Meta();

        return view('inventory.form', $this->data);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $this->data["meta"] = new Meta();
        $this->data["content"] = $this->inventory->getById($id);

        return view('inventory.form', $this->data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'raktarnev' => 'required|max:50|unique:raktar,raktarnev'
        ], $this->messages);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->inventory->insertInventory($request);

        return redirect('/raktarak');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'raktarnev' => ['required', 'max:50', new InventoryRule($id)],
        ], $this->messages);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->inventory->updateInventory($request, $id);

        return redirect('/raktarak');
    }

    /**
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $id)
    {
        $this->inventory->deleteById($id);

        return redirect('/raktarak');
    }

}
