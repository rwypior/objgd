<?php

namespace RWypior\Objgd\Unit;

class Box
{
    public $xy;
    public $wh;

    public function __construct(Coord $xy, Coord $wh)
    {
        $this->xy = $xy;
        $this->wh = $wh;
    }

    public function getSize() : Coord
    {
        return new Coord($this->wh->x - $this->xy->x, $this->wh->y - $this->xy->y);
    }

    public static function fromTtfBbox(array $bbox)
    {
        return new Box(new Coord($bbox[6], $bbox[7]), new Coord($bbox[2], $bbox[3]));
    }
}