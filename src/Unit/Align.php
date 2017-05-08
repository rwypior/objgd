<?php

namespace RWypior\Objgd\Unit;

class Align
{
    const ALIGN_LEFT = 1;
    const ALIGN_RIGHT = 2;
    const ALIGN_CENTER = 3;
    const ALIGN_JUSTIFY = 4;

    const ALIGN_VERTICAL_TOP = 1;
    const ALIGN_VERTICAL_MIDDLE = 2;
    const ALIGN_VERTICAL_BOTTOM = 3;

    const JUSTIFY_LAST_LEFT = 1;
    const JUSTIFY_LAST_RIGHT = 2;
    const JUSTIFY_LAST_CENTER = 3;
    const JUSTIFY_ALL = 4;

    const OPTION_NONE = 0;
    const OPTION_ADJUST_SIZE = 1;

    protected $align;
    protected $valign;
    protected $justify;
    protected $option;

    public function __construct($align = self::ALIGN_LEFT, $valign = self::ALIGN_VERTICAL_TOP, $justify = self::JUSTIFY_LAST_LEFT, $option = self::OPTION_NONE)
    {
        $this->align = $align;
        $this->valign = $valign;
        $this->justify = $justify;
        $this->option = $option;
    }

    /**
     * @return int
     */
    public function getAlign(): int
    {
        return $this->align;
    }

    /**
     * @param int $align
     * @return Align
     */
    public function setAlign(int $align): Align
    {
        $this->align = $align;
        return $this;
    }

    /**
     * @return int
     */
    public function getValign(): int
    {
        return $this->valign;
    }

    /**
     * @param int $valign
     * @return Align
     */
    public function setValign(int $valign): Align
    {
        $this->valign = $valign;
        return $this;
    }

    /**
     * @return int
     */
    public function getJustify(): int
    {
        return $this->justify;
    }

    /**
     * @param int $justify
     * @return Align
     */
    public function setJustify(int $justify): Align
    {
        $this->justify = $justify;
        return $this;
    }

    /**
     * @return int
     */
    public function getOption(): int
    {
        return $this->option;
    }

    /**
     * @param int $option
     * @return Align
     */
    public function setOption(int $option): Align
    {
        $this->option = $option;
        return $this;
    }

    public static function left()
    {
        return new Align();
    }

    public static function center()
    {
        return new Align(self::ALIGN_CENTER);
    }

    public static function right()
    {
        return new Align(self::ALIGN_RIGHT);
    }

    public static function justified($lastLine = self::JUSTIFY_ALL)
    {
        $a = new Align(self::ALIGN_JUSTIFY);
        $a->setJustify($lastLine);
        return $a;
    }
}