<?php

namespace Dommel\LatsBundle\Command;


use Dommel\LatsBundle\Entity\SensorValueEntity;
use Dommel\LatsBundle\Services\Config;
use Dommel\LatsBundle\Services\Sensor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GatherCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this->setName('lats:gather');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sensors = Config::getConfig();

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        foreach ($sensors as $sensorName => $sensor) {
            try {
                $value = $this->getValue($sensorName, $sensor);
            } catch (\Exception $e) {
                $output->writeln("Error importing $sensorName: " . $e->getMessage());
                continue;
            }


            $val = new SensorValueEntity();
            $val->setSensor($sensorName);
            $val->setDate($value->getDate());
            $val->setValue($value->getValue());
            $entityManager->persist($val);
        }
        $entityManager->flush();
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