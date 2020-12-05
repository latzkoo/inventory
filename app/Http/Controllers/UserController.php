<?php

namespace App\Http\Controllers;

use App\Model\Meta;
use App\Rules\Email;
use App\Rules\OldPassword;
use App\Model\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{

    private $title = "Felhasználók";
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
	    $this->data["meta"] = new Meta($this->title);
	    $this->data["users"] = $this->user->getList($request);

		return view('user.list', $this->data);
	}

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->data["meta"] = new Meta($this->title);

        return view('user.form', $this->data);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $this->data["meta"] = new Meta($this->title);
        $this->data["content"] = $this->user->getById($id);

        return view('user.form', $this->data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:50|unique:felhasznalo,email',
            'vezeteknev' => 'required|max:10',
            'keresztnev' => 'required|max:100',
            'jelszo' => 'required|confirmed|max:100'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->user->insertUser($request);

        return redirect('/felhasznalok');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'max:50', new Email($id)],
            'vezeteknev' => 'required|max:10',
            'keresztnev' => 'required|max:100'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->user->updateUser($request, $id);

        return redirect('/felhasznalok');
    }

    /**
     * @return Application|Factory|View
     */
    public function editPassword()
    {
        $this->data["meta"] = new Meta();

        return view('user.password', $this->data);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_jelszo' => ['required', 'max:100', new OldPassword(Auth::user()->getAuthPassword())],
            'new_jelszo' => 'required|confirmed|max:100'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->user->updatePassword($request, Auth::user()->felhasznaloID);

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
