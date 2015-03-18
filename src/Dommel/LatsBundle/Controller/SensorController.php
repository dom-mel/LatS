<?php

namespace Dommel\LatsBundle\Controller;


use DateTime;
use Dommel\LatsBundle\Entity\SensorValueEntity;
use Dommel\LatsBundle\Services\Config;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class SensorController extends FOSRestController {

    public function getSensorsAction()
    {
        $config = Config::getConfig();
        $view = $this->view(array_keys($config));

        return $this->handleView($view);
    }

    public function getSensorAction($name)
    {
        $queryBuilder = $this->get('doctrine.orm.entity_manager')
            ->createQueryBuilder();

        $query = $queryBuilder->select('SensorValueEntity')
            ->from('DommelLatsBundle:SensorValueEntity', 'SensorValueEntity')
            ->where($filter = $queryBuilder->expr()->eq('SensorValueEntity.sensor', ':name'))
            ->setParameter('name', $name)
            ->orderBy('SensorValueEntity.date', 'DESC')
            ->setMaxResults(1000);

        $from = $this->getDate('from');
        $to = $this->getDate('to');

        if ($from !== null) {
            $query->andWhere(
                $queryBuilder->expr()->gte('SensorValueEntity.date' , ':from')
            )->setParameter('from', $from);
            if ($to !== null) {
                $query->andWhere(
                    $queryBuilder->expr()->lte('SensorValueEntity.date' , ':to')
                )->setParameter('to', $to);
            }
        }


        /** @var SensorValueEntity[] $sensorPoints */
        $sensorPoints = $query->getQuery()->getResult();
        $sensorPointCount = count($sensorPoints);
        for ($i = 0; $i < $sensorPointCount; $i++) {
            $sensorPoints[$i] = $sensorPoints[$i]->asArray();
        }

        $view = $this->view($sensorPoints);
        return $this->handleView($view);
    }

    private function getDate($name)
    {
        $request = $this->get('request');
        if (!$request->query->has($name)) {
            return null;
        }

        $date = new DateTime();
        $date->setTimestamp($request->query->getInt($name));
        return $date;
    }

}