<?php

namespace Dommel\LatsBundle\Controller;


use Dommel\LatsBundle\Services\Config;
use Dommel\LatsBundle\Entity\SensorValueEntity;
use Dommel\LatsBundle\Services\Sensor;
use FOS\RestBundle\Controller\FOSRestController;

class LiveSensorController extends FOSRestController {

    public function getSensorAction($name)
    {
        $value = $this->executeSensor($name);
        
        $sensorPoints[] = $value->asArray();

        $view = $this->view($sensorPoints);
        return $this->handleView($view);
    }

    private function executeSensor($sensorName)
    {
        $sensor = Config::getConfigByName($sensorName);

        try {
            $value = $this->getValue($sensorName, $sensor);
            $val = new SensorValueEntity();
            $val->setSensor($sensorName);
            $val->setDate($value->getDate());
            $val->setValue($value->getValue());
            
            return $val;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getValue($sensorName, $sensor)
    {
        if (!is_a($sensor['class'], 'Dommel\LatsBundle\Services\Sensor', true)) {
            throw new \Exception($sensorName . ' is no valid sensor');
        }

        /** @var Sensor $class */
        $class = new $sensor['class']();

        return $class->getValue($sensor['config']);
    }
}