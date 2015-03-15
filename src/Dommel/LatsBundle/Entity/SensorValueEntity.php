<?php

namespace Dommel\LatsBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(name="sensorIdx", columns={"sensor"}),
 *          @ORM\Index(name="dateIdx", columns={"date"})
 *      }
 * )
 */
class SensorValueEntity {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, )
     * @var int
     */
    private $sensor;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * @param int $sensor
     */
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


}