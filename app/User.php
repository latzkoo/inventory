<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "felhasznalo";

    protected $primaryKey = 'felhasznaloID';

    public function getAuthPassword()
    {
        return $this->jelszo;
    }

    protected $fillable = [
        'vezeteknev',
        'keresztnev',
        'email',
        'password',
    ];

    protected $hidden = [
        'jelszo',
    ];


    /**
     * @param Request $request
     * @return Collection
     */
    public function getList(Request &$request): Collection
    {
        $result = self::orderBy("vezeteknev", "ASC")
                      ->orderBy("keresztnev", "ASC");

        if ($request->get("q")) {
            $result->where("vezeteknev", "LIKE", "%{$request->q}%");
            $result->orWhere("keresztnev", "LIKE", "%{$request->q}%");
            $result->orWhere("email", "LIKE", "%{$request->q}%");
        }

        $users = $result->get(["felhasznaloID", "email", "vezeteknev", "keresztnev"]);

        return $users;
    }

    public function insert(Request &$request)
    {
        return DB::insert("INSERT INTO felhasznalo (vezeteknev, keresztnev, email, jelszo) VALUES (?, ?, ?, ?)",
            [$request->post("vezeteknev"), $request->post("keresztnev"),
             $request->post("email"), Hash::make($request->post("jelszo"))]);
    }


    public function deleteById(int $id): void
    {
        self::where("felhasznaloID", $id)->delete();
    }

}
