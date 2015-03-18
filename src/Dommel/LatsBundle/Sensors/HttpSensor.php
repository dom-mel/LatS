<?php
/**
Json path syntax: http://goessner.net/articles/JsonPath/

Config:

'JsonStore':
    class: Dommel\LatsBundle\Sensors\HttpSensor
    config: 
        url: 'http://localhost/web/mockdata/library.json'
        format: json
        path: '$..book[?(@.isbn)].category'    			# path to parse
    display: ~
*/

/*
response -> numfound

$.response.numfound

*/


namespace Dommel\LatsBundle\Sensors;


use Dommel\LatsBundle\Services\SensedValue;
use Dommel\LatsBundle\Services\Sensor;
use Peekmo\JsonPath\JsonStore;


class HttpSensor implements Sensor {
    /**
     *
     * @param array $config configuration for the sensor from sensors.yml
     * @return SensedValue
     * @throws \Exception
     */
    public function getValue(array $config)
    {
        $result = 0;
        
        $json = json_decode(file_get_contents($config['url']), true);

        $store = new JsonStore($json);

        $res = $store->get($config['path'], true);
        
        if (!empty($res)) {
            $result = $res[0];
        }
        
        return new SensedValue($result, SensedValue::TYPE_FLOAT);
    }
}