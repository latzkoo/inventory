<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    protected $table = "raktar";

    protected $fillable = [
        'raktarnev',
    ];


    /**
     * @param Request $request
     * @return array
     */
    public function getList(Request &$request): array
    {
        $query = "SELECT *, (SELECT SUM(mennyiseg)
                  FROM raktarkeszlet
                  WHERE raktarID=raktar.raktarID GROUP BY raktarID) AS termekek_szama
                  FROM raktar ";

        if ($request->q)
            $query .= "WHERE raktarnev LIKE '%{$request->q}%' ";

        $query .= "ORDER BY raktarnev ASC";

        return DB::select($query);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function insertInventory(Request &$request)
    {
        return DB::insert("INSERT INTO raktar (raktarnev) VALUES (?)",
            [$request->post("raktarnev")]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool|int
     */
    public function updateInventory(Request &$request, int $id)
    {
        return DB::update("UPDATE raktar SET raktarnev=? WHERE raktarID=".$id,
            [$request->post("raktarnev")]);
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id): void
    {
        self::where("raktarID", $id)->delete();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        $results = DB::select('SELECT * FROM raktar WHERE raktarID = :id', ['id' => $id]);

        if ($results)
            return $results[0];

        return null;
    }

}
