<?php

namespace RWypior\Objgd;

interface DrawableInterface
{
    /**
     * Draw element on image
     * @param Image $image
     * @return mixed
     */
    public function draw(Image $image);
}