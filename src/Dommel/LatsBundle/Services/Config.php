<?php

namespace Dommel\LatsBundle\Services;

use Symfony\Component\Yaml\Parser;

class Config {

    private static $config;

    public static function getConfig()
    {
        if (self::$config === null) {
            $parser = new Parser();
            self::$config = $parser->parse(file_get_contents(__DIR__ . '/../../../../app/config/sensors.yml'));
        }
        return self::$config;
    }
    
    public static function getConfigByName($sensorName) {
        if (self::$config === null) {
            $parser = new Parser();
            $config = $parser->parse(file_get_contents(__DIR__ . '/../../../../app/config/sensors.yml'));
            if (isset($config[$sensorName])) {
                self::$config = $config[$sensorName];
            } else {
                self::$config = array();
            }
        }
        return self::$config;        
    }

}