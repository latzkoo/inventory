<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class OldPassword implements Rule
{
    /**
     * @var string
     */
    private $oldPassword;


    /**
     * OldPassword constructor.
     * @param string $oldPassword
     */
    public function __construct(string $oldPassword)
    {
        $this->oldPassword = $oldPassword;
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
        return Hash::check($value, $this->oldPassword);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A jelenlegi jelszó nem megfelelő!';
    }
}
