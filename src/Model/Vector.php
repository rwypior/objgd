<?php

namespace RWypior\Objgd\Model;

class Vector
{
    protected $x;
    protected $y;
    protected $z;

    public function __construct(float $x = 0.0, float $y = 0.0, float $z = 0.0)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function toArray()
    {
        return [$this->x, $this->y, $this->z];
    }

    public function sum()
    {
        return $this->x + $this->y + $this->z;
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @param float $x
     * @return Vector
     */
    public function setX(float $x): Vector
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @param float $y
     * @return Vector
     */
    public function setY(float $y): Vector
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return float
     */
    public function getZ(): float
    {
        return $this->z;
    }

    /**
     * @param float $z
     * @return Vector
     */
    public function setZ(float $z): Vector
    {
        $this->z = $z;
        return $this;
    }

}