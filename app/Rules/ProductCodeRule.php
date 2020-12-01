<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductCodeRule implements Rule
{

    private $cikkID;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct($cikkID)
    {
        $this->cikkID = $cikkID;
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
        $count = DB::select("SELECT count(*) AS count FROM cikk WHERE termekkod = ? AND cikkID != ?",
            [$value, $this->cikkID]);

        return !$count[0]->count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A megadott termékkóddal már létezik cikk!';
    }
}
