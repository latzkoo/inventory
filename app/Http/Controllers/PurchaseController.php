<?php

namespace App\Http\Controllers;

use App\Model\Inventory;
use App\Model\Partner;
use App\Model\Product;
use App\Model\Movement;
use App\Model\Meta;
use App\Pager;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PurchaseController extends Controller
{

    private $title = "Beszerzés";
    private $movement;
    private $inventory;
    private $partner;
    private $product;
    private $movementType = "BEVET";

    /**
     * PurchaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->movement = new Movement();
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
        $this->data["meta"] = new Meta($this->title);
        $this->data["count"] = $this->movement->getCount($request, $this->movementType);
        $this->data["pager"] = new Pager($request, $this->data["count"]);
        $this->data["movements"] = $this->movement->getList($request, $this->movementType, $this->data["pager"]);

        return view('purchase.list', $this->data);
	}

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $this->data["meta"] = new Meta($this->title);
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
        $this->data["meta"] = new Meta($this->title);
        $this->data["content"] = $this->movement->getById($id);
        $this->data["items"] = $this->movement->getItems($id);
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

        $this->movement->addMovement($request, $this->movementType, Auth::user()->felhasznaloID);

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
            'partnerID' => 'required|max:50|exists:partner,partnerID',
            'raktarID' => 'required|max:50|exists:raktar,raktarID'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->movement->setMovement($request, $this->movementType, $id);

        return redirect('/beszerzes');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function getNewItem(Request $request)
    {
        $this->data["products"] = $this->product->getList($request);

        return view('purchase.newitem', $this->data);
    }

    /**
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $id)
    {
        try {
            $this->movement->deleteMovement($id, $this->movementType);
            return redirect('/beszerzes?success=1');
        }
        catch (Exception $e) {
            return redirect('/beszerzes?error=1');
        }
    }

}
