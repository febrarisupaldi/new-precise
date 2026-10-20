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

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }

    /**
     * Convert DTO to array
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }

    // /**
    //  * Fill DTO from array
    //  *
    //  * @param array $data
    //  * @return void
    //  */
    // protected function fill(array $data): void
    // {
    //     foreach ($data as $key => $value) {
    //         if (property_exists($this, $key)) {
    //             $this->{$key} = $value;
    //         }
    //     }
    // }

    /**
     * Remove keys from DTO
     *
     * @param array $keys
     * @return array
     */
    public function except(array $keys): array
    {
        return collect($this->toArray())->except($keys)->toArray();
    }
}
