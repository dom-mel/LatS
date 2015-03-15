<?php

namespace Dommel\LatsBundle\Controller;


use Dommel\LatsBundle\Services\Config;
use FOS\RestBundle\Controller\FOSRestController;

class SensorController extends FOSRestController {

    public function getSensorsAction()
    {
        $config = Config::getConfig();
        $view = $this->view(array_keys($config));

        return $this->handleView($view);
    }

    public function getSensorAction($name)
    {
        $sensorPoints = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DommelLatsBundle:SensorValueEntity')
            ->findBy(
                array('sensor' => $name),
                array('date' => 'DESC'),
                500
            );
        $sensorPointCount = count($sensorPoints);
        for ($i = 0; $i < $sensorPointCount; $i++) {
            $sensorPoints[$i] = $sensorPoints[$i]->asArray();
        }

        $view = $this->view($sensorPoints);
        return $this->handleView($view);
    }

}