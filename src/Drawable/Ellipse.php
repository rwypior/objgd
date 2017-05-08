<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Font;
use RWypior\Objgd\Image;
use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Unit\Coord;

class Ellipse implements DrawableInterface
{
    /** @var Color $fillColor */
    protected $fillColor = NULL;

    /** @var Color $borderColor */
    protected $borderColor = NULL;

    /** @var Coord $coord */
    protected $coord;

    /** @var Coord $size */
    protected $size;

    protected $thickness = 1;

    public function __construct(Coord $coord = NULL, Coord $size = NULL)
    {
        if (!$coord)
            $coord = new Coord(0, 0);

        if (!$size)
            $size = new Coord(0, 0);

        $this->coord = $coord;
        $this->size = $size;
    }

    public function draw(Image $image)
    {
        $coord = $image->transformCoord($this->coord);
        $size = $image->transformCoord($this->size);

        if ($this->fillColor)
            imagefilledellipse($image->getGDHandle(), $coord->x, $coord->y, $size->x, $size->y, $this->fillColor->getIntValue());

        if ($this->borderColor)
        {
            imagesetthickness($image->getGDHandle(), $this->thickness);
            imageellipse($image->getGDHandle(), $coord->x, $coord->y, $size->x, $size->y, $this->borderColor->getIntValue());
        }
    }

    /**
     * @return Color
     */
    public function getFillColor(): Color
    {
        return $this->fillColor;
    }

    /**
     * @param Color $fillColor
     * @return Ellipse
     */
    public function setFillColor(Color $fillColor): Ellipse
    {
        $this->fillColor = $fillColor;
        return $this;
    }

    /**
     * @return Color
     */
    public function getBorderColor(): Color
    {
        return $this->borderColor;
    }

    /**
     * @param Color $borderColor
     * @return Ellipse
     */
    public function setBorderColor(Color $borderColor): Ellipse
    {
        $this->borderColor = $borderColor;
        return $this;
    }

    /**
     * @return Coord
     */
    public function getCoord(): Coord
    {
        return $this->coord;
    }

    /**
     * @param Coord $coord
     * @return Ellipse
     */
    public function setCoord(Coord $coord): Ellipse
    {
        $this->coord = $coord;
        return $this;
    }

    /**
     * @return Coord
     */
    public function getSize(): Coord
    {
        return $this->size;
    }

    /**
     * @param Coord $size
     * @return Ellipse
     */
    public function setSize(Coord $size): Ellipse
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return integer
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * @param integer $thickness
     * @return Ellipse
     */
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;
        return $this;
    }

}