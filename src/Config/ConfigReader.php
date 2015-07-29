<?php

namespace Furesz\Doctrine\Config;

use Config;
use OutOfBoundsException;

/**
 * Class ConfigReader.
 *
 *
 * @license Proprietary
 */
class ConfigReader
{
    /**
     * @throws OutOfBoundsException If config value not found.
     *
     * @return string
     */
    public function getDefaultConnectionName()
    {
        $connection = Config::get('doctrine.dbal.default_connection', '');

        if ($connection == '') {
            throw new OutOfBoundsException('Please set up doctrine.dbal.default_connection');
        }

        return $connection;
    }

    /**
     * @param string $name If not set, default connection will be used
     *
     * @throws OutOfBoundsException If default config array not set.
     *
     * @return array
     */
    public function getConnection($name = '')
    {
        if ($name === '') {
            $name = $this->getDefaultConnectionName();
        }

        $connections = Config::get('doctrine.dbal.connections', []);

        if (!array_key_exists($name, $connections)) {
            throw new OutOfBoundsException('Connection not exists in config: '.$name);
        }

        return $connections[$name];
    }
}
