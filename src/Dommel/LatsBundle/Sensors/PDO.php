<?php

namespace Dommel\LatsBundle\Sensors;


use Dommel\LatsBundle\Services\SensedValue;
use Dommel\LatsBundle\Services\Sensor;

class PDO implements Sensor {

    /**
     * readout information
     *
     * @param array $config configuration for the sensor from sensors.yml
     * @return SensedValue
     * @throws \Exception
     */
    public function getValue(array $config)
    {
        $connection = new \PDO($config['dsn'], $config['user'], $config['password']);

        $statement = $connection->query($config['query']);
        if (!$statement->execute()) {
            throw new \Exception('failed to execute query');
        }
        $result = $statement->fetchColumn();
        $statement->closeCursor();

        return new SensedValue($result, SensedValue::TYPE_FLOAT);
    }
}