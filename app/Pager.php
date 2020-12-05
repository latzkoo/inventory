<?php


namespace App;


use Illuminate\Http\Request;

class Pager
{

    private $from = 0;
    private $items = 20;
    private $pages = 1;

    public function __construct(Request $request, $count)
    {
        $this->pages = ceil($count / $this->items);

        if ($request->get("page")) {
            $page = $request->get("page");
        }
        else {
            $page = 1;
        }

        if ($page > $this->pages)
            $page = 1;

        $this->from = $this->items * $page - $this->items;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     */
    public function setFrom(int $from): void
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getItems(): int
    {
        return $this->items;
    }

    /**
     * @param int $items
     */
    public function setItems(int $items): void
    {
        $this->items = $items;
    }


    /**
     * @return false|float|int
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param false|float|int $pages
     */
    public function setPages($pages): void
    {
        $this->pages = $pages;
    }


}
