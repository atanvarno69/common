<?php
/**
 * TypeCheckTrait trait file.
 *
 * @package   Atan\Common
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */
 
 namespace Atan\Common;
 
 trait TypeCheckTrait
{
    /**
     * Checks if given array is associative.
     *
     * An array is associative if it contains only `string` keys.
     *
     * @param array $input The array to check.
     *
     * @return bool `true` if associative, `false` otherwise.
     */
    protected function isAssociativeArray(array $input): bool
    {
        foreach ($input as $key => $value) {
            if (!is_string($key)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Checks if given input is `string` or `array` of only `string` values.
     *
     * @param mixed $input The input to check.
     *
     * @return bool `true` if `string` or `array` of only `string` values,
     *              `false` otherwise.
     */
    protected function isStringOrStringArray($input): bool
    {
        if (!is_string($input) && !is_array($input)) {
            return false;
        }
        $input = (array) $input;
        foreach ($input as $test) {
            if (!is_string($test)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Checks if given array is numeric.
     *
     * An array is numeric if it contains only `int` keys.
     *
     * @param array $input The array to check.
     *
     * @return bool `true` if numeric, `false` otherwise.
     */
    protected function isNumericArray(array $input): bool
    {
        foreach ($input as $key => $value) {
            if (!is_int($key)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Checks if given array is mixed.
     *
     * An array is mixed if it contains both `int` and `string` keys.
     *
     * @param array $input The array to check.
     *
     * @return bool `true` if mixed, `false` otherwise.
     */
    protected function isMixedArray(array $input): bool
    {
        return (!$this->isAssociativeArray($input)
            && !$this->isNumericArray($input));
    }
}
