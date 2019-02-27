<?php

namespace Barn\entities;

/**
 * Cow entity class
 *
 * @property int $id
 * @property string $name
 * @property array $milkYield
 * @property string $unit
 */
class CowEntity
{
    public $id;
    public $name;
    public $milkYieldRange;
    public $unit = 'litre';
    public $rating;

    public function __construct($id, $name, $milkYieldRange = [8, 12])
    {
        $this->id = $id;
        $this->name = $name;
        $this->milkYieldRange = $milkYieldRange;
        $this->milkYield = \random_int(
            $this->milkYieldRange[0],
            $this->milkYieldRange[1]
        );
        $this->rating = (int) round($this->milkYield/$this->milkYieldRange[1] * 100);
    }
}
