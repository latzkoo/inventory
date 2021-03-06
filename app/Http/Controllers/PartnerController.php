<?php

namespace App\Http\Controllers;

use App\Model\Meta;
use App\Model\Partner;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PartnerController extends Controller
{
    private $title = "Partnerek";
    private $partner;

    /**
     * PartnerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->partner = new Partner();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function get(Request $request)
	{
	    $this->data["meta"] = new Meta($this->title);
	    $this->data["partners"] = $this->partner->getList($request);

		return view('partner.list', $this->data);
	}

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->data["meta"] = new Meta($this->title);

        return view('partner.form', $this->data);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $this->data["meta"] = new Meta($this->title);
        $this->data["content"] = $this->partner->getById($id);

        return view('partner.form', $this->data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partnernev' => 'required|max:100',
            'iranyitoszam' => 'required|max:5',
            'telepules' => 'required|max:50',
            'utca' => 'nullable|max:50',
            'hazszam' => 'nullable|max:10'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->partner->insertPartner($request);

        return redirect('/partnerek');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'partnernev' => 'required|max:100',
            'iranyitoszam' => 'required|max:5',
            'telepules' => 'required|max:50',
            'utca' => 'nullable|max:50',
            'hazszam' => 'nullable|max:10'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->partner->updatePartner($request, $id);

        return redirect('/partnerek');
    }

    /**
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $id)
    {
        try {
            $this->partner->deleteById($id);
            return redirect('/partnerek?success=1');
        }
        catch (Exception $e) {
            return redirect('/partnerek?error=1');
        }
    }

}
