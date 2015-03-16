<?php

namespace Dommel\LatsBundle\Sensors;


use Dommel\LatsBundle\Services\SensedValue;
use Dommel\LatsBundle\Services\Sensor;

class CPU implements Sensor {

    /**
     * Get CPU usage in percent
     * Ripped from http://stackoverflow.com/questions/13131003/get-cpu-percent-usage-in-php
     *
     * @param array $config configuration for the sensor from sensors.yml
     * @return SensedValue
     * @throws \Exception
     */
    public function getValue(array $config)
    {
        $result = 0;
        
        $stat1 = file('/proc/stat'); 
        sleep(1); 
        $stat2 = file('/proc/stat'); 
        $info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0])); 
        $info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0])); 
        $dif = array(); 
        $dif['user'] = $info2[0] - $info1[0]; 
        $dif['nice'] = $info2[1] - $info1[1]; 
        $dif['sys'] = $info2[2] - $info1[2]; 
        $dif['idle'] = $info2[3] - $info1[3]; 
        $total = array_sum($dif); 
        $cpu = array(); 
        foreach($dif as $x=>$y) {
            $cpu[$x] = round($y / $total * 100, 1);
        }
        
        $result = $cpu[$config['stat']];
        
        return new SensedValue($result, SensedValue::TYPE_FLOAT);
    }

}