<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Image;
use RWypior\Objgd\Model\LineStyle;
use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Unit\Coord;

class Arc implements DrawableInterface
{
    /** @var Coord $coordA */
    protected $coord;

    /** @var Coord $size */
    protected $size;

    /** @var Coord $angles */
    protected $angles;

    /** @var  */
    protected $thickness;

    /** @var Color $color */
    protected $color;

    /** @var LineStyle $style */
    protected $style = NULL;

    public function __construct(Coord $coord = NULL, Coord $size = NULL, Coord $angles = NULL)
    {
        if ($coord == NULL)
            $coord = new Coord();

        if ($size == NULL)
            $size = new Coord();

        if ($angles == NULL)
            $angles = new Coord();

        $this->color = Color::fromName('white');

        $this->coord = $coord;
        $this->size = $size;
        $this->angles = $angles;
    }

    public function draw(Image $image)
    {
        $coord = $image->transformCoord($this->coord);
        $size = $image->transformCoord($this->size);

        $color = $this->color->getIntValue();

        if ($this->style)
        {
            $color = $this->style->getType();
            $length = $this->thickness == 1 ? 0 : $this->length($image);
            imagesetstyle($image->getGDHandle(), $this->style->getStyle($length));
        }

        imagesetthickness($image->getGDHandle(), $this->thickness);

        imagearc($image->getGDHandle(), $coord->x, $coord->y, $size->x, $size->y, $this->angles->x, $this->angles->y, $color);
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
     * @return Arc
     */
    public function setCoord(Coord $coord): Arc
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
     * @return Arc
     */
    public function setSize(Coord $size): Arc
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return Coord
     */
    public function getAngles(): Coord
    {
        return $this->angles;
    }

    /**
     * @param Coord $angles
     * @return Arc
     */
    public function setAngles(Coord $angles): Arc
    {
        $this->angles = $angles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * @param mixed $thickness
     * @return Arc
     */
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;
        return $this;
    }

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @param Color $color
     * @return Arc
     */
    public function setColor(Color $color): Arc
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return LineStyle
     */
    public function getStyle(): LineStyle
    {
        return $this->style;
    }

    /**
     * @param LineStyle $style
     * @return Arc
     */
    public function setStyle(LineStyle $style): Arc
    {
        $this->style = $style;
        return $this;
    }

}