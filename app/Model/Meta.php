<?php

namespace App\Model;

class Meta
{

    private $title;

    /**
     * Meta constructor.
     * @param $title
     */
    public function __construct($title = null)
    {
        if ($title)
            $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title ? $this->title .= " - Raktár" : "Raktár";
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

}
