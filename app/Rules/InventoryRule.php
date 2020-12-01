<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class InventoryRule implements Rule
{

    private $raktarID;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct($raktarID)
    {
        $this->raktarID = $raktarID;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $count = DB::select("SELECT count(*) AS count FROM raktar WHERE raktarnev = ? AND raktarID != ?",
            [$value, $this->raktarID]);

        return !$count[0]->count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A megadott névvel már létezik raktár!';
    }
}
