<?php

namespace Dommel\LatsBundle\Sensors;


use Dommel\LatsBundle\Services\SensedValue;
use Dommel\LatsBundle\Services\Sensor;

class CPU implements Sensor {

    /**
     * readout information
     *
     * @param array $config configuration for the sensor from sensors.yml
     * @return SensedValue
     * @throws \Exception
     */
    public function getValue(array $config)
    {
        $result = 0;
        
        if (is_callable('sys_getloadavg')) {
            $values = sys_getloadavg();
            $result = $values[0];
        }
        
        
        return new SensedValue($result, SensedValue::TYPE_FLOAT);
    }

}