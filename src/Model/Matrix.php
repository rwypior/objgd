<?php

namespace RWypior\Objgd\Model;

class Matrix
{
    protected $x;
    protected $y;
    protected $z;

    public function __construct(Vector $x, Vector $y, Vector $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function toArray()
    {
        return
            [
                $this->x->toArray(),
                $this->y->toArray(),
                $this->z->toArray()
            ];
    }

    public function sum()
    {
        return $this->x->sum() + $this->y->sum() + $this->z->sum();
    }

    /**
     * @return Vector
     */
    public function getX(): Vector
    {
        return $this->x;
    }

    /**
     * @param Vector $x
     * @return Matrix
     */
    public function setX(Vector $x): Matrix
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return Vector
     */
    public function getY(): Vector
    {
        return $this->y;
    }

    /**
     * @param Vector $y
     * @return Matrix
     */
    public function setY(Vector $y): Matrix
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return Vector
     */
    public function getZ(): Vector
    {
        return $this->z;
    }

    /**
     * @param Vector $z
     * @return Matrix
     */
    public function setZ(Vector $z): Matrix
    {
        $this->z = $z;
        return $this;
    }

}