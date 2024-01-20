<?php


namespace Modules\Sass\Entities;

/**
 * Class Type
 * @package Modules\Sass\Entities
 */

class Type
{
    const CONTRACTOR = 1;
    const TRANSPORT = 2;
    /**
     * @var array
     */
    private array $types = [];

    public function __construct()
    {
        $this->types = [
            self::CONTRACTOR => trans('sass::companies.type.contractor'),
            self::TRANSPORT => trans('sass::companies.type.transport'),
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists(): array
    {
        return $this->types;
    }

    /**
     * Get the post status
     * @param int $typeId
     * @return string
     */
    public function get(int $typeId): string
    {
        if (isset($this->types[$typeId])) {
            return $this->types[$typeId];
        }

        return $this->types[self::TRANSPORT];
    }
}
