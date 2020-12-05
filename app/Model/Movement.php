<?php

namespace App\Model;

use App\Pager;
use App\Util;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Movement extends Model
{

    private $stock;

    public function __construct()
    {
        parent::__construct();
        $this->stock = new Stock();
    }

    /**
     * @param Request $request
     * @param string $type
     * @return array
     */
    public function getCount(Request &$request, string $type): int
    {
        $query = "SELECT COUNT(*) AS count FROM raktarmozgas WHERE tipus = ?";

        if ($request->get("q")) {
            $query .= " AND bizonylatszam LIKE '%".$request->get("q")."%'";
        }

        $count = DB::select($query, [$type]);

        if ($count)
            return $count[0]->count;

        return 0;
    }

    /**
     * @param Request $request
     * @param string $type
     * @param int|null $from
     * @param int $items
     * @return array
     */
    public function getList(Request &$request, string $type, Pager $pager): array
    {
        $query = "SELECT raktarmozgas.*, raktar.raktarnev, (SELECT SUM(mennyiseg) FROM tartalmazza
                    WHERE mozgasID=raktarmozgas.mozgasID) AS termekek_szama,
                    (SELECT SUM(ar * mennyiseg) FROM tartalmazza
                    WHERE mozgasID=raktarmozgas.mozgasID) AS osszeg
                  FROM raktarmozgas
                  INNER JOIN raktar ON raktarmozgas.raktarID = raktar.raktarID
                  WHERE tipus = ?";

        if ($request->get("q")) {
            $query .= " AND bizonylatszam LIKE '%".$request->get("q")."%'";
        }

        $query .= " ORDER BY kelte DESC LIMIT ?, ?";

        return DB::select($query, [$type, $pager->getFrom(), $pager->getItems()]);
    }

    /**
     * @param Request $request
     * @param string $type
     * @param int $felhasznaloID
     * @return bool
     */
    public function insertMovement(Request &$request, string $type, int $felhasznaloID)
    {
        return DB::table("raktarmozgas")->insertGetId([
                    "bizonylatszam" => Util::createIdNumber($type == "BEVET" ? "IN": "OU"),
                    "partnerID" => $request->post("partnerID"),
                    "raktarID" => $request->post("raktarID"),
                    "felhasznaloID" => $felhasznaloID,
                    "tipus" => $type
                ]);
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
    public function addMovement(Request $request, string $type, int $felhasznaloID)
    {
        DB::beginTransaction();

        try {
            $movementID = $this->insertMovement($request, $type, $felhasznaloID);
            $this->insertMovementItems($request, $movementID);

            if ($type == "BEVET") {
                $this->stock->insertStock($request);
            }
            else {
                $movement = [
                    "movement" => $this->getById($movementID),
                    "items" => $this->getItems($movementID)
                ];

                $this->stock->reduceStock($movement);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * @param Request $request
     * @param string $type
     * @param int $movementID
     * @return void
     */
    public function setMovement(Request &$request, string $type, int $movementID)
    {
        DB::beginTransaction();

        try {
            $movement = [
                "movement" => $this->getById($movementID),
                "items" => $this->getItems($movementID)
            ];

            $this->updateMovement($request, $movementID);
            $this->deleteMovementItems($movementID);
            $this->insertMovementItems($request, $movementID);
            $this->stock->setStock($request, $type, $movement);

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

    public function getItems(int $movementID)
    {
        $query = "SELECT * FROM tartalmazza WHERE mozgasID = ?";

        return DB::select($query, [$movementID]);
    }

    private function updateMovement(Request $request, int $movementID)
    {
        DB::update("UPDATE raktarmozgas SET partnerID=?, raktarID=? WHERE mozgasID=?",
            [$request->post("partnerID"), $request->post("raktarID"), $movementID]);
    }

    private function deleteMovementItems(int $movementID)
    {
        DB::delete("DELETE FROM tartalmazza WHERE mozgasID=?", [$movementID]);
    }

    public function deleteMovement(int $movementID, string $type)
    {
        DB::beginTransaction();

        try {
            $movement = [
                "movement" => $this->getById($movementID),
                "items" => $this->getItems($movementID)
            ];

            if ($type == "BEVET")
                $this->stock->reduceStock($movement);
            else
                $this->stock->increaseStock($movement);

            $this->deleteMovementItems($movementID);
            $this->deleteById($movementID);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
        }
    }

}
