<?php

namespace RWypior\Objgd\Effects;

use RWypior\Objgd\EffectInterface;
use RWypior\Objgd\Image;
use RWypior\Objgd\Model\Matrix;
use RWypior\Objgd\Model\Vector;

class Gaussian implements EffectInterface
{
    protected $amount;

    /**
     * Gaussian constructor.
     * @param int $amount amount of blur
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function getMatrix() : Matrix
    {
        return new Matrix(
            new Vector(1, 2, 1),
            new Vector(2, 4, 2),
            new Vector(1, 2, 1)
        );
    }

    public function getCoefficient(): float
    {
        return $this->getMatrix()->sum();
    }

    public function getOffset(): float
    {
        return 0;
    }

    public function apply(Image $image)
    {
        for ($i = 0; $i < $this->amount; ++$i)
            imageconvolution($image->getGDHandle(), $this->getMatrix()->toArray(), $this->getCoefficient(), $this->getOffset());
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Gaussian
     */
    public function setAmount(int $amount): Gaussian
    {
        $this->amount = $amount;
        return $this;
    }

}