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

    /**
     * @param Request $request
     * @return bool
     */
    public function insertUser(Request &$request)
    {
        return DB::insert("INSERT INTO felhasznalo (vezeteknev, keresztnev, email, jelszo) VALUES (?, ?, ?, ?)",
            [$request->post("vezeteknev"), $request->post("keresztnev"),
             $request->post("email"), Hash::make($request->post("jelszo"))]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool|int
     */
    public function updateUser(Request &$request, int $id)
    {
        return DB::update("UPDATE felhasznalo SET vezeteknev=?, keresztnev=?, email=? WHERE felhasznaloID=".$id,
            [$request->post("vezeteknev"), $request->post("keresztnev"), $request->post("email")]);
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id): void
    {
        DB::delete("DELETE FROM felhasznalo WHERE felhasznaloID=?", [$id]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        $results = DB::select('SELECT * FROM felhasznalo WHERE felhasznaloID=?', [$id]);

        if ($results)
            return $results[0];

        return null;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return int
     */
    public function updatePassword(Request $request, int $id)
    {
        return DB::update("UPDATE felhasznalo SET jelszo=? WHERE felhasznaloID=?",
            [Hash::make($request->post("new_jelszo")), $id]);
    }

}
