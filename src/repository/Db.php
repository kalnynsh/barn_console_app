<?php

namespace Barn\repository;

class Db
{
    /**@property \PDO $db */
    protected $db;

    /**
     * Conctructor
     *
     * @param mixed $connection
     * @param array $config
     */
    public function __construct(
        $connection,
        $config = [\PDO::ATTR_PERSISTENT => true]
    ) {
        if (!$connection instanceof \PDO) {
            if (is_string($connection)) {
                $connection = ['dsn' => $connection];
            }

            if (!\is_array($connection)) {
                throw new \InvalidArgumentException(
                    'First argument of '
                    . __CLASS__
                    . 'must be an instance of PDO, a DSN string, '
                    . 'or configuration array.'
                );
            }

            if (!isset($connection['dsn'])) {
                throw new \InvalidArgumentException(
                    'Configuration array must contain "dsn".'
                );
            }

            $connection = \array_merge(
                [
                    'username' => null,
                    'password' => null,
                    'options' => $config,
                ],
                $connection
            );

            $connection = new \PDO(
                $connection['dsn'],
                $connection['username'],
                $connection['password'],
                $connection['options']
            );
        }

        $this->db = $connection;

        $connection->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }

    public function getConnection(): \PDO
    {
        return $this->db;
    }
}
