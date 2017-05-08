<?php

namespace RWypior\Objgd\Model;

use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Util\Math;

class LineStyle
{
    protected $style = [];
    protected $type = IMG_COLOR_STYLED;
    protected $autocorrect;

    /**
     * @param int $type can be IMG_COLOR_STYLED or IMG_COLOR_STYLEDBRUSHED
     * @param bool $autocorrect correct segments size to line length
     */
    public function __construct($type = IMG_COLOR_STYLED, bool $autocorrect = true)
    {
        $this->autocorrect = $autocorrect;
        $this->setType($type);
    }

    public function addSegment(Color $color, int $count)
    {
        $this->style[] = [$color, $count];
    }

    public function getStyle($length = 0)
    {
        $result = [];

        foreach($this->style as $style)
        {
            list($color, $count) = $style;
            
            if ($this->autocorrect && $length != 0)
                $correctCount = Math::gcd($count, $length);
            else
                $correctCount = $count;

            for($i = 0; $i < $correctCount; ++$i)
            {
                $result[] = $color->getIntValue();
            }
        }

        return $result;
    }

    /**
     * @param int $type can be IMG_COLOR_STYLED or IMG_COLOR_STYLEDBRUSHED
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}