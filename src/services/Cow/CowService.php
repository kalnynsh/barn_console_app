<?php

namespace Barn\services\Cow;

use Barn\repository\CawRepository;
use Barn\entities\CowEntity;

class CowService
{
    /** @property array $names */
    private $names;

    /** @property string $table */
    private $table;

    /** @property CawRepository $db */
    private $repository;

    public function __construct(array $names, CawRepository $repository)
    {
        $this->names = $names;
        $this->repository = $repository;
        $this->table = 'cows';
    }

    public function init(): string
    {
        if ($this->repository->getLastId() == 0) {
            $this->populate();

            return \sprintf('The table %s was populated', $this->table);
        }

        return \sprintf('The table %s already has been populated', $this->table);
    }

    public function create($id, $name): CowEntity
    {
        return new CowEntity($id, $name);
    }

    private function populate(): void
    {
        $id = 0;

        foreach ($this->names as $name) {
            $id++;
            $cow = $this->create($id, $name);

            $this->repository->insert(
                $id,
                $cow->name,
                $cow->milkYield,
                $cow->rating
            );
        }
    }

    public function getBest(): array
    {
        return $this->repository->getBestArray();
    }

    public function printBest(): void
    {
        $results = $this->getBest();
        echo 'Three best cows:' . PHP_EOL;

        foreach ($results as $result) {
            echo 'Cow name: '
            . $result['name']
            . ', '
            . 'liters: '
            . $result['milk_yield']
            . ', rating: '
            . $result['rating']
            . '%;' . PHP_EOL;
        }
    }

    public function getAllMilk()
    {
        $allMilk = $this->repository->getAllByColumn('milk_yield');
        $milksData = \array_column($allMilk, 'milk');

        return \array_sum($milksData);
    }

    public function printAllMilk(): void
    {
        echo 'Get all milks today: '
        . $this->getAllMilk()
        . ' liter.' . PHP_EOL;
    }
}
