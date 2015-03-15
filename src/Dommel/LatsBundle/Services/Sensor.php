<?php

namespace Dommel\LatsBundle\Services;

/**
 * Gives information from a given component
 */
interface Sensor {

    /**
     * readout information
     *
     * @param array $config configuration for the sensor from sensors.yml
     * @return SensedValue
     * @throws \Exception
     */
    public function getValue(array $config);

}