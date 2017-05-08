<?php

namespace RWypior\Objgd\Drawable;

use RWypior\Objgd\DrawableInterface;
use RWypior\Objgd\Font;
use RWypior\Objgd\Image;
use RWypior\Objgd\Unit\Align;
use RWypior\Objgd\Unit\Box;
use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Unit\Coord;

class Text implements DrawableInterface
{
    protected $text;

    protected $buffer = [];

    protected $coord;

    /** @var Font $font */
    protected $font;

    /** @var Color $color */
    protected $color;

    protected $angle = 0;

    protected $maxWidth = 0;

    protected $encoding;

    /** @var Align $align */
    protected $align;

    protected $size = 10;

    const LINE_SPACE_RATIO = 1.55;
    const SPACE_RATIO = 0.4;
    const MIN_SPACE_SIZE = 20;

    public function __construct(string $text = '', Coord $coord = NULL)
    {
        if ($coord == NULL)
            $coord = new Coord();

        $this->setAlign(Align::left());
        $this->setColor(Color::fromName('white'));

        $this->setText($text);
        $this->setCoord($coord);
    }

    /**
     * Explode given text by given text or array delimiter
     * @param string|array $delimiter
     * @param string $text
     * @return array
     */
    public static function explode($delimiter, string $text)
    {
        if (is_array($delimiter))
            return explode($delimiter[0], str_replace($delimiter, $delimiter[0], $text));
        return explode($delimiter, $text);
    }



    /**
     * Parse string tags
     * @param string $text string to parse
     * @return array array of parsed text blocks
     */
    private function parseText(string $text) : array
    {
        $enc = mb_detect_encoding($text);
        $len = mb_strlen($text, $enc);
        $parts = [['', '']];
        $special = false;
        $type = '';
        $closing = false;
        for ($i = 0; $i < $len; ++$i) {
            $chr = mb_substr($text, $i, 1, $enc);

            if ($chr == '[') {
                $special = true;
                $type = '';
                continue;
            }
            else if ($chr == ']') {
                if ($closing) {
                    $closing = false;
                    $type = '';
                }
                $special = false;
                $parts[] = [$type, ''];
                continue;
            }
            else if ($special && $chr == '/') {
                $closing = true;
                continue;
            }

            if ($special)
                $type .= $chr;
            else
                $parts[count($parts) - 1][1] .= $chr;
        }

        return $parts;
    }

    /**
     * Calculate width of all lines in $split array
     * @param array $split
     * @param $size
     * @param Font $font
     * @param $angle
     * @return integer[]
     */
    private function calculateSize(array $split, $size, Font $font, $angle)
    {
        $sizes = [new Coord(0, 0)];

        foreach($split as $part)
        {
            list($parttype, $parttext) = $part;
            $fontvariant = $font->variant($parttype);

            $dim = Box::fromTtfBbox(imagettfbbox($size, $angle, $fontvariant, $parttext));
            $sizes[count($sizes) - 1]->x += $dim->getSize()->x + (substr_count($parttext, ' ') - 1) * self::SPACE_RATIO;
            $sizes[count($sizes) - 1]->y = $size;

            $enc = mb_detect_encoding($parttext);
            if (mb_substr($parttext, -1, 1, $enc) == "\n")
                $sizes[] = new Coord(0, 0);
        }

        return $sizes;
    }

    /**
     * Create line blocks from given text by given criteria - max length and explicit new lines
     * @param $text
     * @param int $angle
     * @param int $fontSize
     * @param Font $font
     * @param int $maxWidth
     * @return array
     */
    private function splitIntoLines($text, int $angle, int $fontSize, Font $font, int $maxWidth)
    {
        $res = [];
        $buffer = '';

        $wordIndex = 1;
        foreach($text as $block)
        {
            $lines = explode("\n", $block[1]);
            $countLines = count($lines);

            foreach($lines as $lineindex => $line)
            {
                $isLastLine = $lineindex + 1 == $countLines;

                $expl = explode(' ', $line);
                foreach($expl as $i => $word)
                {
                    $buffer .= $word . ' ';

                    // if $maxWidth parameter is specified - detect where does the string exceed it and break in that place
                    if ($maxWidth)
                    {
                        $fontVariant = $font->variant($block[0]);

                        $checkBuffer = $buffer;
                        if (isset($expl[$i + 1]))
                            $checkBuffer .= $expl[$i + 1];

                        $writtenDim = Box::fromTtfBbox(imagettfbbox($fontSize, $angle, $fontVariant, $checkBuffer));

                        if ($writtenDim->getSize()->x + self::MIN_SPACE_SIZE * $wordIndex++ >= $maxWidth)
                        {
                            $res[] = [$block[0], trim($buffer)."\n"];
                            $buffer = '';
                            $wordIndex = 1;
                        }
                    }
                }

                // push everything that's left in the buffer
                //if (trim($buffer))
                {
                    $res[] = [$block[0], trim($buffer) . ($isLastLine ? '' : "\n")];
                    $buffer = '';
                }
            }
        }

        return $res;
    }

    public function setText(string $text)
    {
        $this->text = $text;
        $this->encoding = mb_detect_encoding($text);
    }

    /**
     * @return Coord
     */
    public function getCoord()
    {
        return $this->coord;
    }

    /**
     * @param Coord $coord
     * @return Text
     */
    public function setCoord(Coord $coord)
    {
        $this->coord = $coord;
        return $this;
    }

    /**
     * @return Font
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param Font $font
     * @return Text
     */
    public function setFont(Font $font)
    {
        $this->font = $font;
        return $this;
    }

    /**
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param Color $color
     * @return Text
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return int
     */
    public function getAngle(): int
    {
        return $this->angle;
    }

    /**
     * @param int $angle
     * @return Text
     */
    public function setAngle(int $angle): Text
    {
        $this->angle = $angle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * @param mixed $maxWidth
     * @return Text
     */
    public function setMaxWidth($maxWidth): Text
    {
        $this->maxWidth = $maxWidth;
        return $this;
    }

    /**
     * @return Align
     */
    public function getAlign(): Align
    {
        return $this->align;
    }

    /**
     * @param Align $align
     */
    public function setAlign(Align $align)
    {
        $this->align = $align;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    public function draw(Image $image)
    {
        $coord = $image->transformCoord($this->coord);
        $maxWidth = $image->transformDimension($this->maxWidth, $image->getSize()->x);
        $split = $this->parseText($this->text);
        $split = $this->splitIntoLines($split, $this->angle, $this->size, $this->font, $maxWidth);
        $lineSizes = $this->calculateSize($split, $this->size, $this->font, $this->angle);
        $countLines = count($lineSizes);

        $imgsize = $image->getSize();
        $y = 0;
        $xoff = 0;
        $line = 0;
        $lineWidth = 0;

        $totalHeight = 0;
        foreach($lineSizes as $lineSize)
        {
            $totalHeight += $lineSize->y;
        }

        $justify = $this->align->getAlign() == Align::ALIGN_JUSTIFY;

        $justifyLeft = $justify && $this->align->getJustify() == Align::JUSTIFY_LAST_LEFT;
        $justifyCenter = $justify && $this->align->getJustify() == Align::JUSTIFY_LAST_CENTER;
        $justifyRight = $justify && $this->align->getJustify() == Align::JUSTIFY_LAST_RIGHT;
        $justifySide = $justifyLeft | $justifyCenter | $justifyRight;

        $verticalCenter = $this->align->getValign() == ALIGN::ALIGN_VERTICAL_MIDDLE;

        $leftright = new Coord($imgsize->x, 0);

        $yOff = $verticalCenter ? $totalHeight * -0.5 : 0;

        foreach($split as $part) {
            list($parttype, $parttext) = $part;
            $linesize = $lineSizes[$line]->x;
            $fontvariant = $this->font->variant($parttype);

            $words = array_values(array_filter(explode(' ', $parttext)));

            $isLastLine = $line == $countLines - 1;

            if ($justify && !($isLastLine && $justifySide))
            {
                $countSpaces = count($words) - 1;
                $sizeDiff = max($maxWidth - $linesize, 0);
                $spaceOffset = $countSpaces ? $sizeDiff / $countSpaces : 0;

                $spaceWidth = $this->size * self::SPACE_RATIO + $spaceOffset;
                $xOffBase = (-$spaceOffset * $countSpaces) * 0.5;
            }
            else
            {
                $spaceWidth = $this->size * self::SPACE_RATIO;
                $xOffBase = 0;
            }

            foreach($words as $word)
            {
                if ($this->align->getAlign() == Align::ALIGN_CENTER)
                    $x = $coord->x - $linesize * 0.5 + $xoff + $xOffBase;
                else if ($this->align->getAlign() == Align::ALIGN_RIGHT)
                    $x = $imgsize->x - $linesize + $xoff - $coord->x + $xOffBase;
                else
                    $x = $coord->x + $xoff + $xOffBase;

                if ($isLastLine && $justifySide)
                    $x = $leftright->x + $xoff;

                $writtenDim = Box::fromTtfBbox(imagettfbbox($this->size, $this->angle, $fontvariant, $word));

                if ($x < $leftright->x)
                    $leftright->x = $x;
                else if ($x + $writtenDim->getSize()->x > $leftright->y)
                    $leftright->y = $x + $writtenDim->getSize()->x;

                imagettftext($image->getGDHandle(), $this->size, $this->angle, $x, $coord->y + $y + $yOff + $this->size, $this->color->getIntValue(), $fontvariant, $word);

                $currentWidth = $writtenDim->getSize()->x + $spaceWidth;
                $xoff += $currentWidth;
                $lineWidth += $currentWidth;

                if (mb_substr($word, -1, 1, $this->encoding) == "\n")
                {
                    $y += $this->size * self::LINE_SPACE_RATIO;
                    $xoff = 0;
                    $lineWidth = 0;
                    ++$line;
                }
            }
        }
    }
}