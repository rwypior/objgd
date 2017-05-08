<?php

namespace RWypior\Objgd;

interface EffectInterface
{
    /**
     * Apply effect on image
     * @param Image $image
     * @return mixed
     */
    public function apply(Image $image);
}