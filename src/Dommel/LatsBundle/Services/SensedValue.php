<?php

namespace Dommel\LatsBundle\Services;

/**
 * A value measured by a Sensor
 * @package Dommel\LatsBundle\Services
 */
class SensedValue {

    /**
     * @var \DateTime date of measure
     */
    private $date;

    /**
     * @var mixed measured value
     */
    private $value;

    /**
     * @var int type of the value - use SensedValue::TYPE_* constants
     */
    private $type;

    const TYPE_INT = 1;
    const TYPE_FLOAT = 2;

    public function __construct($value, $type, $date = null)
    {
        $this->value = $value;
        $this->type = $type;
        if ($date === null) {
            $date = new \DateTime();
        }
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }




}