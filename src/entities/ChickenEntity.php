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
class ChickenEntity
{
    public $id;
    public $name;
    public $eggYieldRange;
    public $eggYield;
    public $unit = 'pieces';
    public $rating;

    public function __construct($id, $name, $eggYieldRange = [0, 1])
    {
        $this->id = $id;
        $this->name = $name;
        $this->eggYieldRange = $eggYieldRange;
        $this->eggYield = \random_int(
            $this->eggYieldRange[0],
            $this->eggYieldRange[1]
        );
        $this->rating = $this->eggYield * 100;
    }
}
