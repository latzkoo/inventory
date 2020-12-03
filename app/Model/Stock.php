<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Stock
{

    /**
     * @param int $inventoryID
     * @return array
     */
    public function getList(int $inventoryID): array
    {
        return DB::select("SELECT cikkID, mennyiseg FROM raktarkeszlet WHERE raktarID=?", [$inventoryID]);
    }

    public function getStock(int $cikkID, int $inventoryID)
    {
        $results = DB::select("SELECT mennyiseg FROM raktarkeszlet WHERE cikkID=? AND raktarID=?", [$cikkID, $inventoryID]);

        if ($results)
            return $results[0]->mennyiseg;

        return null;
    }

    /**
     * @param int $inventoryID
     * @param int $cikkID
     * @param int $stock
     */
    private function addStock(int $inventoryID, int $cikkID, int $stock)
    {
        DB::insert("INSERT INTO raktarkeszlet (cikkID, raktarID, mennyiseg) VALUES (?, ?, ?)",
            [$cikkID, $inventoryID, $stock]);
    }

    /**
     * @param int $inventoryID
     * @param int $cikkID
     * @param int $stock
     */
    private function updateStock(int $inventoryID, int $cikkID, int $stock)
    {
        DB::update("UPDATE raktarkeszlet SET mennyiseg=? WHERE cikkID=? AND raktarID=?",
            [$stock, $cikkID, $inventoryID]);
    }

    /**
     * @param Request $request
     * @param array|null $current
     */
    public function insertStock(Request $request)
    {
        foreach ($request->post("cikkID") as $key => $cikkID) {
            $currentStock = $this->getStock($cikkID, $request->post("raktarID"));

            if ($currentStock) {
                $this->updateStock($request->post("raktarID"), $cikkID,
                    $currentStock + $request->post("mennyiseg")[$key]);
            }
            else {
                $this->addStock($request->post("raktarID"), $cikkID, $request->post("mennyiseg")[$key]);
            }
        }
    }

    /**
     * @param Request $request
     * @param string $type
     * @param array|null $movement
     */
    public function setStock(Request $request, string $type, array $movement)
    {
        if ($type == "BEVET")
            $this->reduceStock($movement);
        else
            $this->increaseStock($movement);

        foreach ($request->post("cikkID") as $key => $cikkID) {
            $currentStock = $this->getStock($cikkID, $request->post("raktarID"));

            if (isset($currentStock) && $currentStock >= 0) {
                $this->updateStock($request->post("raktarID"), $cikkID,
                    $currentStock - $request->post("mennyiseg")[$key]);
            }
        }
    }

    /**
     * @param $raktarID
     * @param $cikkID
     */
    private function deleteStock(int $raktarID, int $cikkID)
    {
        DB::delete("DELETE FROM raktarkeszlet WHERE raktarID = ? AND cikkID = ?", [$raktarID, $cikkID]);
    }

    /**
     * @param array $movement
     */
    public function reduceStock(array $movement)
    {
        foreach ($movement["items"] as $cikk) {
            $currentStock = $this->getStock($cikk->cikkID, $movement["movement"]->raktarID);

            if ($currentStock - $cikk->mennyiseg == 0) {
                $this->deleteStock($movement["movement"]->raktarID, $cikk->cikkID);
            }
            else {
                $this->updateStock($movement["movement"]->raktarID, $cikk->cikkID,
                    $currentStock - $cikk->mennyiseg);
            }
        }
    }

    /**
     * @param array $movement
     */
    public function increaseStock(array $movement)
    {
        foreach ($movement["items"] as $cikk) {
            $currentStock = $this->getStock($cikk->cikkID, $movement["movement"]->raktarID);

            if (isset($currentStock) && $currentStock >= 0) {
                $this->updateStock($movement["movement"]->raktarID, $cikk->cikkID,
                    $currentStock + $cikk->mennyiseg);
            }
            else {
                $this->addStock($movement["movement"]->raktarID, $cikk->cikkID, $cikk->mennyiseg);
            }
        }
    }


}
