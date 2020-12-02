<?php

namespace App\Model;

use App\Util;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{

    /**
     * @param Request $request
     * @return array
     */
    public function getList(Request &$request): array
    {
        $query = "SELECT raktarmozgas.*, (SELECT SUM(mennyiseg) FROM tartalmazza
                    WHERE mozgasID=raktarmozgas.mozgasID) AS termekek_szama,
                    (SELECT SUM(ar * mennyiseg) FROM tartalmazza
                    WHERE mozgasID=raktarmozgas.mozgasID) AS osszeg
                  FROM raktarmozgas WHERE tipus = 'BEVET'
                  ORDER BY kelte DESC";

        return DB::select($query);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function insertMovement(Request &$request, int $felhasznaloID)
    {
        return DB::table("raktarmozgas")->insertGetId([
                    "bizonylatszam" => Util::createIdNumber("IN"),
                    "partnerID" => $request->post("partnerID"),
                    "raktarID" => $request->post("raktarID"),
                    "felhasznaloID" => $felhasznaloID,
                    "tipus" => "BEVET"
                ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool|int
     */
    public function updatePurchase(Request &$request, int $id)
    {
        return DB::update("UPDATE raktarmozgas SET raktarnev=? WHERE mozgasID=".$id,
            [$request->post("raktarnev")]);
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id): void
    {
        DB::delete("DELETE FROM raktarmozgas WHERE mozgasID=?", [$id]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        $results = DB::select('SELECT * FROM raktarmozgas WHERE mozgasID = :id', ['id' => $id]);

        if ($results)
            return $results[0];

        return null;
    }

    /**
     * @param Request $request
     * @param $felhasznaloID
     */
    public function addPurchase(Request $request, $felhasznaloID)
    {
        DB::beginTransaction();

        try {
            $movementID = $this->insertMovement($request, $felhasznaloID);
            $this->insertMovementItems($request, $movementID);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
        }
    }

    public function insertMovementItems(Request $request, int $movementID)
    {
        foreach ($request->post("cikkID") as $key => $cikkID) {
            DB::insert("INSERT INTO tartalmazza (mozgasID, cikkID, ar, mennyiseg) VALUES (?, ?, ?, ?)",
                [$movementID, $cikkID, $request->post("ar")[$key], $request->post("mennyiseg")[$key]]);
        }
    }

}
