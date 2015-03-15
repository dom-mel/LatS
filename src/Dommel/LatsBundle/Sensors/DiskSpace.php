<?php

namespace Dommel\LatsBundle\Sensors;


use Dommel\LatsBundle\Services\SensedValue;
use Dommel\LatsBundle\Services\Sensor;

class DiskSpace implements Sensor {

    /**
     * readout information
     *
     * @param array $config configuration for the sensor from sensors.yml
     * @return SensedValue
     * @throws \Exception
     */
    public function getValue(array $config)
    {
        $result = disk_total_space( $config['dir'] );
        
        return new SensedValue($result, SensedValue::TYPE_INT);
    }

}