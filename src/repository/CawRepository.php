<?php

namespace Barn\repository;

use Barn\repository\Db;

class CawRepository
{
    /**@property \PDO $db */
    protected $db;

    /**@property array $config */
    protected $config;

    /**
     * Conctructor
     *
     * @param mixed $connection
     * @param array $config
     */
    public function __construct(Db $db)
    {
        $this->db = $db->getConnection();
        $this->config['table'] = 'caws';
    }

    public function insert(
        $id = null,
        $name = 'Milka',
        $milk_yield = 8,
        $rating = 67
    ) {
        $sql = sprintf(
            'INSERT INTO %s
            (`id`, `name`, `milk_yield`, `rating`)
            VALUES (:id, :name, :milk_yield, :rating)',
            $this->config['table']
        );
        $stm = $this->db->prepare($sql);

        return $stm->execute(compact('id', 'name', 'milk_yield', 'rating'));
    }

    public function update(
        $id,
        $name = 'Milka',
        $milk_yield = 8,
        $rating = 67
    ) {
        $sql = sprintf(
            'UPDATE %s
            SET `name`=:name, `milk_yield`=:milk_yield, `rating`=:rating
            WHERE `id`=:id',
            $this->config['table']
        );
        $stm = $this->db->prepare($sql);

        return $stm->execute(compact('id', 'name', 'milk_yield', 'rating'));
    }

    public function find($id)
    {
        $sql = \sprintf(
            'SELECT * FROM %s WHERE id=:id',
            $this->config['table']
        );
        $stm = $this->db->prepare($sql);

        return $stm->execute(compact('id')) ?? null;
    }

    public function getLastId(): int
    {
        $sql = \sprintf(
            'SELECT MAX(`id`) AS `id` FROM %s',
            $this->config['table']
        );

        $stm = $this->db->query($sql);

        return (int) $stm->fetch(\PDO::FETCH_ASSOC)['id'] ?? 0;
    }

    public function getBestArray($limit = 3)
    {
        $sql = \sprintf(
            'SELECT name, milk_yield, rating
            FROM %s
            ORDER BY rating DESC
            LIMIT %u',
            $this->config['table'],
            $limit
        );

        $stm = $this->db->query($sql);

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBestObj($limit = 3)
    {
        $sql = \sprintf(
            'SELECT name, milk_yield, rating
            FROM %s
            ORDER BY rating DESC
            LIMIT %u',
            $this->config['table'],
            $limit
        );

        $stm = $this->db->query($sql);

        $stm->setFetchMode(
            \PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE,
            Barn\entities\CowEntity::class
        );

        return $stm->fetchAll();
    }

    public function getAllByColumn($column = 'milk_yield'): array
    {
        $sql = \sprintf(
            'SELECT %s AS %s
            FROM %s',
            $column,
            'milk',
            $this->config['table']
        );

        $stm = $this->db->query($sql);

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
}
