<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Font;
use RWypior\Objgd\Image;
use RWypior\Objgd\Model\PieChartDataset;
use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Unit\Coord;

class PieChart implements DrawableInterface
{
    /** @var PieChartDataset[] $data */
    protected $data = [];

    /** @var Coord $coord */
    protected $coord;

    /** @var Coord $size */
    protected $size;

    /** @var Font $font */
    protected $font;

    /** @var bool $drawNames */
    protected $drawNames = false;

    /** @var null|Color $borderColor */
    protected $borderColor = NULL;

    /** @var float $borderThickness */
    protected $borderThickness = 1.5;

    /**
     * @param Image $image
     * @return null
     */
    public function draw(Image $image)
    {
        $this->refreshPercentages();

        $coord = $image->transformCoord($this->coord);
        $size = $image->transformCoord($this->size);

        $prevAngle = 0;

        foreach($this->data as $name => $data)
        {
            $color = $data->getColor();
            $percent = $data->getPercent();
            $angle = $prevAngle + 360 * $percent;

            $arc1 = new \RWypior\Objgd\Drawable\Arc();
            $arc1->setCoord($this->coord);
            $arc1->setAngles(new \RWypior\Objgd\Unit\Coord($prevAngle, $angle));
            $arc1->setSize($size);
            $arc1->setColor($color);
            $arc1->setFillColor($color);

            $pointCircumference = new \RWypior\Objgd\Unit\Coord(
                $size->x * 0.5 * cos(deg2rad($angle)) + $coord->x,
                $size->y * 0.5 * sin(deg2rad($angle)) + $coord->y
            );

            $line1 = new \RWypior\Objgd\Drawable\Line();
            $line1->setCoordA($coord);
            $line1->setCoordB($pointCircumference);
            $line1->setColor($color);

            $midAngle = ($prevAngle + $angle) * 0.5;

            $pointText = new \RWypior\Objgd\Unit\Coord(
                $size->x * 0.7 * cos(deg2rad($midAngle)) + $coord->x,
                $size->y * 0.7 * sin(deg2rad($midAngle)) + $coord->y
            );

            $percentReadable = round($percent * 100);
            $label = $percentReadable . '%';
            if ($this->drawNames)
                $label .= "\n{$data->getName()}";
            $text = new \RWypior\Objgd\Drawable\Text($label);
            $text->setFont($this->font);
            $text->setCoord($pointText);
            $text->setSize(15);
            $text->setAlign(\RWypior\Objgd\Unit\Align::center());

            $image->drawElement($arc1);
            $image->drawElement($line1);
            $image->drawElement($text);

            $prevAngle = $angle;
        }

        if ($this->borderColor)
            $this->drawBorder($image, $coord, $size);
    }

    /**
     * Draw border around image
     * Using Xiaolin Wu antialiased lines algorithm
     * @param Image $image
     * @param Coord $coord
     * @param Coord $size
     */
    protected function drawBorder(Image $image, Coord $coord, Coord $size)
    {
        $a = $size->x * 0.5;
        $b = $size->y * 0.5;
        $thickness = $this->borderThickness / min($a, $b);

        for ($x = 0; $x <= $a + 1; $x++)
        {
            for ($y = 0; $y <= $b + 1; $y++)
            {
                $one = $x * $x / ($a * $a) + $y * $y / ($b * $b);
                $error = ($one - 1) / $thickness;

                if ($error > 1)
                    break;

                if ($error < -1)
                    continue;

                imagesetpixel($image->getGDHandle(), $coord->x + $x, $coord->y + $y, $this->borderColor->getIntValue());
                imagesetpixel($image->getGDHandle(), $coord->x - $x, $coord->y + $y, $this->borderColor->getIntValue());
                imagesetpixel($image->getGDHandle(), $coord->x - $x, $coord->y - $y, $this->borderColor->getIntValue());
                imagesetpixel($image->getGDHandle(), $coord->x + $x, $coord->y - $y, $this->borderColor->getIntValue());
            }
        }
    }

    protected function refreshPercentages()
    {
        $sum = 0;

        foreach($this->data as $entry)
        {
            $sum += $entry->getAmount();
        }

        foreach($this->data as $entry)
        {
            $entry->setPercent($entry->getAmount() / $sum);
        }
    }

    /**
     * @return null|Color
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * @param null|Color $borderColor
     * @return PieChart
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
        return $this;
    }

    /**
     * @return float
     */
    public function getBorderThickness(): float
    {
        return $this->borderThickness;
    }

    /**
     * @param float $borderThickness
     * @return PieChart
     */
    public function setBorderThickness(float $borderThickness): PieChart
    {
        $this->borderThickness = $borderThickness;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDrawNames(): bool
    {
        return $this->drawNames;
    }

    /**
     * @param bool $drawNames
     * @return PieChart
     */
    public function setDrawNames(bool $drawNames): PieChart
    {
        $this->drawNames = $drawNames;
        return $this;
    }

    /**
     * @param PieChartDataset $data
     */
    public function addData(PieChartDataset $data)
    {
        $this->data[] = $data;
    }

    /**
     * @return PieChartDataset[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return Font
     */
    public function getFont(): Font
    {
        return $this->font;
    }

    /**
     * @param Font $font
     * @return PieChart
     */
    public function setFont(Font $font): PieChart
    {
        $this->font = $font;
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
     * @return PieChart
     */
    public function setCoord(Coord $coord): PieChart
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
     * @return PieChart
     */
    public function setSize(Coord $size): PieChart
    {
        $this->size = $size;
        return $this;
    }

}