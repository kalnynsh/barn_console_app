<?php

namespace Barn\services\Cow;

use Barn\repository\ChickenRepository;
use Barn\entities\ChickenEntity;

class ChickenService
{
    /** @property array $names */
    private $names;

    /** @property string $table */
    private $table;

    /** @property ChickenRepository $db */
    private $repository;

    public function __construct(array $names, ChickenRepository $repository)
    {
        $this->names = $names;
        $this->repository = $repository;
        $this->table = 'chickens';
    }

    public function init(): string
    {
        if ($this->repository->getLastId() == 0) {
            $this->populate();

            return \sprintf('The table %s was populated', $this->table);
        }

        return \sprintf('The table %s already has been populated', $this->table);
    }

    public function create($id, $name): ChickenEntity
    {
        return new ChickenEntity($id, $name);
    }

    private function populate(): void
    {
        $id = 0;

        foreach ($this->names as $name) {
            $id++;
            $chicken = $this->create($id, $name);

            $this->repository->insert(
                $id,
                $chicken->name,
                $chicken->eggYield,
                $chicken->rating
            );
        }
    }

    public function getAllEggs()
    {
        $allEggs = $this->repository->getAllByColumn('eggs_yield');
        $eggsData = \array_column($allEggs, 'eggs');

        return \array_sum($eggsData);
    }

    public function printAllEggs(): void
    {
        echo 'Get all eggs today: '
        . $this->getAllEggs()
        . ' pieces.' . PHP_EOL;
    }
}
