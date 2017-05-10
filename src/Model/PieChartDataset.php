<?php

namespace RWypior\Objgd\Model;

use RWypior\Objgd\Unit\Color;

class PieChartDataset
{
    protected $name;
    protected $amount;
    protected $percent;
    protected $color;

    public function __construct($name, float $amount, Color $color)
    {
        $this->name = $name;
        $this->amount = $amount ?: 0.0;
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return PieChartDataset
     */
    public function setName(string $name): PieChartDataset
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return PieChartDataset
     */
    public function setAmount(float $amount): PieChartDataset
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->percent;
    }

    /**
     * @param mixed $percent
     * @return PieChartDataset
     */
    public function setPercent(float $percent): PieChartDataset
    {
        $this->percent = $percent;
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
     * @return PieChartDataset
     */
    public function setColor(Color $color): PieChartDataset
    {
        $this->color = $color;
        return $this;
    }

}