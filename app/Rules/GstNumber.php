<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GstNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $pan;
    public function __construct($pan)
    {
        $this->pan = $pan;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Example regex for Indian GST number
        $isValidGst = preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}[Z]{1}[0-9A-Z]{1}$/', $value);
        $isPanInGst = strpos($value, $this->pan) !== false;

        return $isValidGst && $isPanInGst;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'GST Format invalid,Please try again.';
    }
}
