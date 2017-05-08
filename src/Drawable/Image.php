<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Unit\Box;
use RWypior\Objgd\Unit\Coord;

class Image implements DrawableInterface
{
    /** @var Coord $size */
    protected $size;

    /** @var Coord $coord */
    protected $coord;

    /** @var \RWypior\Objgd\Image $image */
    protected $image;

    /**
     * Image constructor.
     * @param \RWypior\Objgd\Image $img Image to draw
     */
    public function __construct(\RWypior\Objgd\Image $img)
    {
        $this->coord = new Coord();
        $this->image = $img;
        $this->size = $img->getSize();
    }

    /**
     * @param \RWypior\Objgd\Image $image Image to draw on
     */
    public function draw(\RWypior\Objgd\Image $image)
    {
        $coord = $image->transformCoord($this->coord);

        imagecopyresampled(
            $image->getGDHandle(), $this->image->getGDHandle(),
            $coord->x, $coord->y,
            0, 0,
            $this->size->x, $this->size->y,
            $image->getSize()->x, $image->getSize()->y);
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
     * @return Image
     */
    public function setSize(Coord $size): Image
    {
        $this->size = $size;
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
     * @return Image
     */
    public function setCoord(Coord $coord): Image
    {
        $this->coord = $coord;
        return $this;
    }

    /**
     * @return \RWypior\Objgd\Image
     */
    public function getImage(): \RWypior\Objgd\Image
    {
        return $this->image;
    }

    /**
     * @param \RWypior\Objgd\Image $image
     * @return Image
     */
    public function setImage(\RWypior\Objgd\Image $image): Image
    {
        $this->image = $image;
        return $this;
    }

    public function scale(float $scale)
    {
        $this->size = $this->image->getSize()->multiply($scale);
    }

}