<?php

namespace RWypior\Objgd\Unit;

class Coord
{
    public $x;
    public $y;

    public function __construct($x = 0.0, $y = 0.0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return bool whenever both X and Y components are NULL
     */
    public function isNull()
    {
        return $this->x === NULL && $this->y === NULL;
    }

    /**
     * Multiply coord
     * @param float|Coord $x x-coordinate or Coord to multiply by
     * @param float|null $y y-coordinate, if null then both X and Y are multiplied by X
     * @return Coord
     */
    public function multiply($x, $y = NULL)
    {
        $coord = clone $this;

        if ($x instanceof Coord)
        {
            $y = $x->y;
            $x = $x->x;
        }

        if ($y === NULL)
        {
            $coord->x *= $x;
            $coord->y *= $x;
        }
        else
        {
            $coord->x *= $x;
            $coord->y *= $y;
        }

        return $coord;
    }

    /**
     * Calculate distance to another coord
     * @param Coord $dest
     * @return float
     */
    public function distanceTo(Coord $dest)
    {
        $x = $this->x - $dest->x;
        $y = $this->y - $dest->y;
        return sqrt($x * $x + $y * $y);
    }

    /**
     * Get value of subtraction
     * @param Coord $coord
     * @return Coord
     */
    public function subtract(Coord $coord)
    {
        return new Coord($this->x - $coord->x, $this->y - $coord->y);
    }

    /**
     * Get value of addition
     * @param Coord $coord
     * @return Coord
     */
    public function add(Coord $coord)
    {
        return new Coord($this->x + $coord->x, $this->y + $coord->y);
    }
}