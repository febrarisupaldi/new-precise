<?php

namespace App\DTOs;

use Illuminate\Http\Request;

abstract class BaseDTO
{
    /**
     * Create DTO from Request
     *
     * @param Request $request
     * @return static
     */
    abstract public static function fromRequest(Request $request);

    /**
     * Convert DTO to array
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
