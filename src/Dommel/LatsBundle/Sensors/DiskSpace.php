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
        $result = disk_free_space( $config['dir'] );
        
        if (isset($config['format'])) {
            switch ($config['format']) {
                case 'kB' :
                    $result = $result / 1024 ;
                    break;
                case 'MB' : 
                    $result = $result / (1024 * 1024);
                    break;
                case 'GB' : 
                    $result = $result / (1024 * 1024 * 1024);
                    break;
            }
        }
        
        return new SensedValue($result, SensedValue::TYPE_FLOAT);
    }

}