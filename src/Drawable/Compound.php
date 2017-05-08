<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Image;

class Compound implements DrawableInterface
{
    /** @var DrawableInterface[] $elements */
    protected $elements = [];

    public function draw(Image $image)
    {
        foreach($this->elements as $element)
            $element->draw($image);
    }

    public function addElement(DrawableInterface $drawable)
    {
        $this->elements[] = $drawable;
    }

    public function clear()
    {
        $this->elements = [];
    }

}