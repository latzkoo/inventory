<?php

namespace App\Http\Controllers;

use App\Model\Meta;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class UserController extends Controller
{
    private $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->user = new User();;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function get(Request $request)
	{
	    $this->data["meta"] = new Meta();
	    $this->data["users"] = $this->user->getList($request);

		return view('users.list', $this->data);
	}

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->data["meta"] = new Meta();

        return view('users.form', $this->data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function insert(Request $request)
    {
        try {
            $this->user->insert($request);
        }
        catch (Exception $e) {
            return redirect()->back()->withInput();
        }

        return redirect('/felhasznalok');
    }

    /**
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $id)
    {
        $this->user->deleteById($id);

        return redirect('/felhasznalok');
    }

}
