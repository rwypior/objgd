<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Image;
use RWypior\Objgd\Model\LineStyle;
use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Unit\Coord;

class Line implements DrawableInterface
{
    /** @var Coord $coordA */
    protected $coordA;

    /** @var Coord $coordB */
    protected $coordB;

    /** @var  */
    protected $thickness;

    /** @var Color $color */
    protected $color;

    /** @var LineStyle $style */
    protected $style = NULL;

    public function __construct(Coord $coordA = NULL, Coord $coordB = NULL)
    {
        if ($coordA == NULL)
            $coordA = new Coord();

        if ($coordB == NULL)
            $coordB = new Coord();

        $this->color = Color::fromName('white');

        $this->coordA = $coordA;
        $this->coordB = $coordB;
    }

    public function draw(Image $image)
    {
        $coordA = $image->transformCoord($this->coordA);
        $coordB = $image->transformCoord($this->coordB);

        $color = $this->color->getIntValue();

        if ($this->style)
        {
            $color = $this->style->getType();
            $length = $this->thickness == 1 ? 0 : $this->length($image);
            imagesetstyle($image->getGDHandle(), $this->style->getStyle($length));
        }

        imagesetthickness($image->getGDHandle(), $this->thickness);

        imageline($image->getGDHandle(), $coordA->x, $coordA->y, $coordB->x, $coordB->y, $color);
    }

    public function length(Image $image)
    {
        $coordA = $image->transformCoord($this->coordA);
        $coordB = $image->transformCoord($this->coordB);

        return $coordA->distanceTo($coordB);
    }

    /**
     * @return Coord
     */
    public function getCoordA(): Coord
    {
        return $this->coordA;
    }

    /**
     * @param Coord $coordA
     * @return Line
     */
    public function setCoordA(Coord $coordA): Line
    {
        $this->coordA = $coordA;
        return $this;
    }

    /**
     * @return Coord
     */
    public function getCoordB(): Coord
    {
        return $this->coordB;
    }

    /**
     * @param Coord $coordB
     * @return Line
     */
    public function setCoordB(Coord $coordB): Line
    {
        $this->coordB = $coordB;
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
     * @return Line
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
     * @return Line
     */
    public function setColor(Color $color): Line
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
     */
    public function setStyle(LineStyle $style = NULL)
    {
        $this->style = $style;
    }

}