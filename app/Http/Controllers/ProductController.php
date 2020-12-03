<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\Meta;
use App\Rules\ProductCodeRule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{
    private $product;
    private $messages = [
        'termekkod.unique' => 'A megadott termékkóddal már létezik cikk!'
    ];

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function get(Request $request)
	{
	    $this->data["meta"] = new Meta();
	    $this->data["products"] = $this->product->getList($request);

		return view('product.list', $this->data);
	}

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->data["meta"] = new Meta();

        return view('product.form', $this->data);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $this->data["meta"] = new Meta();
        $this->data["content"] = $this->product->getById($id);

        return view('product.form', $this->data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'termekkod' => 'required|max:50|unique:cikk,termekkod',
            'megnevezes' => 'required|max:100',
            'ar' => 'required|numeric|min:0'
        ], $this->messages);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->product->insertProduct($request);

        return redirect('/cikkek');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'termekkod' => ['required', 'max:50', new ProductCodeRule($id)],
            'megnevezes' => 'required|max:100',
            'ar' => 'required|numeric|min:0'
        ], $this->messages);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->product->updateProduct($request, $id);

        return redirect('/cikkek');
    }

    public function getById(int $id)
    {
        $product = $this->product->getById($id);

        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }

    /**
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $id)
    {
        $this->product->deleteById($id);

        return redirect('/cikkek');
    }

}
