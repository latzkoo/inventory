<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
     * @return Collection
     */
    public function getList(Request &$request): Collection
    {
        $result = self::orderBy("megnevezes", "ASC");

        if ($request->get("q"))
            $result->where("termekkod", "LIKE", "%{$request->q}%");
            $result->orWhere("megnevezes", "LIKE", "%{$request->q}%");

        $products = $result->get();

        return $products;
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
