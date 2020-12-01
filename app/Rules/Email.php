<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Email implements Rule
{

    private $felhasznaloID;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct($felhasznaloID)
    {
        $this->felhasznaloID = $felhasznaloID;
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
        $count = DB::select("SELECT count(*) AS count FROM felhasznalo WHERE email = ? AND felhasznaloID != ?",
            [$value, $this->felhasznaloID]);

        return !$count[0]->count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A megadott e-mail címmel már létezik felhasználó!';
    }
}
