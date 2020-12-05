<?php

namespace App\Model;

use App\Pager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = "cikk";

    protected $fillable = [
        'termekkod',
        'megnevezes',
        'ar'
    ];

    /**
     * @param Request $request
     * @return int
     */
    public function getCount(Request &$request): int
    {
        $query = "SELECT COUNT(*) AS count FROM cikk";

        if ($request->get("q")) {
            $query .= " WHERE cikk.termekkod LIKE '%".$request->get("q")."%'
                        OR cikk.megnevezes LIKE '%".$request->get("q")."%'";
        }

        $count = DB::select($query);

        if ($count)
            return $count[0]->count;

        return 0;
    }

    /**
     * @param Request $request
     * @param int|null $raktarID
     * @return array
     */
    public function getList(Request &$request, int $raktarID = null, Pager $pager = null): array
    {
        $query = "SELECT cikk.* FROM cikk ";

        if ($raktarID) {
            $query .= " INNER JOIN raktarkeszlet ON raktarkeszlet.cikkID=cikk.cikkID AND raktarkeszlet.raktarID=".$raktarID;
        }
        elseif ($request->get("q")) {
            $query .= " WHERE cikk.termekkod LIKE '%".$request->get("q")."%'
                        OR cikk.megnevezes LIKE '%".$request->get("q")."%'";
        }

        $query .= " ORDER BY cikk.megnevezes, cikk.termekkod ASC LIMIT ?, ?";

        return DB::select($query, [$pager->getFrom(), $pager->getItems()]);

        return DB::select($query);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function insertProduct(Request &$request)
    {
        return DB::insert("INSERT INTO cikk (termekkod, megnevezes, ar) VALUES (?, ?, ?)",
            [$request->post("termekkod"), $request->post("megnevezes"), $request->post("ar")]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool|int
     */
    public function updateProduct(Request &$request, int $id)
    {
        return DB::update("UPDATE cikk SET termekkod=?, megnevezes=?, ar=? WHERE cikkID=".$id,
            [$request->post("termekkod"), $request->post("megnevezes"), $request->post("ar")]);
    }

    /**
     * @param int $id
     */
    public function deleteById(int $id): void
    {
        DB::delete("DELETE FROM cikk WHERE cikkID=?", [$id]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        $results = DB::select('SELECT * FROM cikk WHERE cikkID=?', [$id]);

        if ($results)
            return $results[0];

        return null;
    }

}
