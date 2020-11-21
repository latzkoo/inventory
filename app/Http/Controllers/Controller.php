<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

//            $language = Config::get('app.locale');
//
//            $this->data['language'] = $language;
//            $this->data['menus'] = (new Menu)->get($language);

            return $next($request);
        });
    }
}
