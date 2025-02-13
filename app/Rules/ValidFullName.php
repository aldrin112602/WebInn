<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFullName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Trim and split the name into words
        $words = array_filter(explode(' ', trim($value)), fn($word) => trim($word) !== '');

        // Validate all words contain only alphabetic characters
        foreach ($words as $word) {
            if (!preg_match('/^[A-Za-z]+$/', $word)) {
                $fail('The :attribute must contain only alphabetic characters.');
                return;
            }
        }


        // Ensure there are at least two words (first and last name)
        if (count($words) < 2) {
            $fail('The :attribute must contain at least a first name and a last name.');
            return;
        }


        $name = strlen($words[0]) < 2
            ? 'first'
            : (strlen($words[count($words) - 1]) < 2
                ? 'last'
                : null);

        if ($name) {
            $fail("The $name name must be at least 2 characters long.");
            return;
        }



        // If there are more than two words, validate the middle name
        if (count($words) > 2) {
            $middleName = $words[count($words) - 2]; // Second-to-last word is the middle name

            if (!preg_match('/^[A-Za-z]+$/', $middleName)) {
                $fail('The :attribute must have a valid middle name if more than two words.');
            }
        }
    }
}
