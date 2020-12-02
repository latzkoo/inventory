<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Partner extends Model
{
    protected $table = "partner";

    protected $fillable = [
        'partnernev',
        'iranyitoszam',
        'telepules',
        'utca',
        'hazszam'
    ];


    /**
     * @param Request $request
     * @return array
     */
    public function getList(Request &$request): array
    {
        $query = "SELECT partnerID, partnernev,
                      CONCAT(iranyitoszam, ' ', telepules, ' ',
                      IF(utca IS NOT NULL, utca, ''), ' ',
                      IF(hazszam IS NOT NULL, hazszam, '')) AS cim
                  FROM partner ";

        if ($request->get("q")) {
            $query .= "WHERE partnernev LIKE '%{$request->get("q")}%' OR
                             iranyitoszam LIKE '%{$request->get("q")}%' OR
                             telepules LIKE '%{$request->get("q")}%' OR
                             utca LIKE '%{$request->get("q")}%'";
        }

        $query .= "ORDER BY partnernev ASC";

        return DB::select($query);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function insertPartner(Request &$request)
    {
        return DB::insert("INSERT INTO partner (partnernev, iranyitoszam, telepules, utca, hazszam) VALUES (?, ?, ?, ?, ?)",
            [$request->post("partnernev"), $request->post("iranyitoszam"), $request->post("telepules"),
             $request->post("utca"), $request->post("hazszam")]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool|int
     */
    public function updatePartner(Request &$request, int $id)
    {
        return DB::update("UPDATE partner SET partnernev=?, iranyitoszam=?, telepules=?, utca=?, hazszam=? WHERE partnerID=".$id,
            [$request->post("partnernev"), $request->post("iranyitoszam"), $request->post("telepules"),
             $request->post("utca"), $request->post("hazszam")]);
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id): void
    {
        DB::delete("DELETE FROM partner WHERE partnerID=?", [$id]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        $results = DB::select('SELECT * FROM partner WHERE partnerID = :id', ['id' => $id]);

        if ($results)
            return $results[0];

        return null;
    }

}
