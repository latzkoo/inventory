<?php

namespace App\Http\Controllers;

use App\Model\Inventory;
use App\Model\Partner;
use App\Model\Product;
use App\Model\Purchase;
use App\Model\Meta;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    private $purchase;
    private $inventory;
    private $partner;
    private $product;

    /**
     * PurchaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->purchase = new Purchase();
        $this->inventory = new Inventory();
        $this->partner = new Partner();
        $this->product = new Product();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function get(Request $request)
	{
	    $this->data["meta"] = new Meta();
	    $this->data["movements"] = $this->purchase->getList($request);

		return view('purchase.list', $this->data);
	}

    /**
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $this->data["meta"] = new Meta();
        $this->data["partners"] = $this->partner->getList($request);
        $this->data["inventories"] = $this->inventory->getList($request);
        $this->data["products"] = $this->product->getList($request);

        return view('purchase.form', $this->data);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(Request $request, int $id)
    {
        $this->data["meta"] = new Meta();
        $this->data["content"] = $this->purchase->getById($id);
        $this->data["partners"] = $this->partner->getList($request);
        $this->data["inventories"] = $this->inventory->getList($request);
        $this->data["products"] = $this->product->getList($request);

        return view('purchase.form', $this->data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partnerID' => 'required|max:50|exists:partner,partnerID',
            'raktarID' => 'required|max:50|exists:raktar,raktarID'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->purchase->addPurchase($request, Auth::user()->felhasznaloID);

        return redirect('/beszerzes');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'raktarnev' => ['required', 'max:50', new PurchaseRule($id)],
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->purchase->updatePurchase($request, $id);

        return redirect('/beszerzes');
    }

    /**
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $id)
    {
        $this->purchase->deleteById($id);

        return redirect('/beszerzes');
    }

}
