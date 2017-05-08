<?php

namespace RWypior\Objgd;

use RWypior\Objgd\Unit\Color;
use RWypior\Objgd\Unit\Coord;

class Image
{
    const TYPE_JPG = 'jpg';
    const TYPE_JPEG = 'jpg';
    const TYPE_PNG = 'png';
    const TYPE_BMP = 'bmp';

    protected $saveWithAlpha = false;

    protected $handle;
    protected $currentColor = NULL;

    public function __construct($handle)
    {
        $this->handle = $handle;
    }

    public function __destruct()
    {
        imagedestroy($this->handle);
    }

    public function fill(Color $color, Coord $coord = NULL)
    {
        if (!$coord)
            $coord = new Coord(0, 0);

        imagefill($this->getGDHandle(), $coord->x, $coord->y, $color->getIntValue());
    }

    /**
     * @param Coord $size
     * @return Image
     */
    public static function createEmpty(Coord $size)
    {
        return new Image(imagecreatetruecolor($size->x, $size->y));
    }

    /**
     * Create image from file
     * @param string $content image contents
     * @return Image
     */
    public static function createFromFile(string $content)
    {
        return new Image(imagecreatefromstring($content));
    }

    /**
     * Create image from file
     * @param string $path path to load image from
     * @return Image
     */
    public static function load(string $path)
    {
        if (!file_exists($path))
            throw new \InvalidArgumentException("Could not find file \"$path\"");

        return self::createFromFile(file_get_contents($path));
    }

    public function enableAlpha($enable = true)
    {
        $this->saveWithAlpha = $enable;
        imagesavealpha($this->handle, $enable);
        imagealphablending($this->handle, $enable);
    }

    /**
     * Get image size
     */
    public function getSize() : Coord
    {
        return new Coord(imagesx($this->handle), imagesy($this->handle));
    }

    /**
     * Apply unit to dimension
     * @param string $dim dimension to transform
     * @param integer $parentDim parent dimension
     * @return int absolute-value dimension
     */
    public function transformDimension($dim, $parentDim) : int
    {
        if (substr($dim, -1) == '%')
            return intval($dim) * 0.01 * $parentDim;

        return intval($dim);
    }

    /**
     * Apply units to coordinate
     */
    public function transformCoord(Coord $coord) : Coord
    {
        $imgs = $this->getSize();
        return new Coord(
            $this->transformDimension($coord->x, $imgs->x),
            $this->transformDimension($coord->y, $imgs->y)
        );
    }

    /**
     * Draw element on the image
     * @param DrawableInterface $drawable
     * @return Image
     */
    public function drawElement(DrawableInterface $drawable)
    {
        $drawable->draw($this);
        return $this;
    }

    /**
     * Apply effect
     * @param EffectInterface $effect
     */
    public function applyEffect(EffectInterface $effect)
    {
        $effect->apply($this);
    }

    /**
     * Get native GD handle
     * @return resource
     */
    public function getGDHandle()
    {
        return $this->handle;
    }

    /**
     * Display the image
     * @param string $type image type
     * @param float $quality image quality in 0-1 range
     */
    public function render($type = self::TYPE_JPEG, float $quality = 1.0)
    {
        $this->output(NULL, $type, $quality);
    }

    /**
     * Output image to file
     * @param string $path where to save the image
     * @param string $type image type
     * @param float $quality image quality in 0-1 range
     */
    public function save(string $path, $type = self::TYPE_JPEG, float $quality = 1.0)
    {
        $this->output($path, $type, $quality);
    }

    /**
     * Output image to file
     * @param string $type image type
     * @param float $quality image quality in 0-1 range
     * @return string binary image content
     */
    public function getContents($type = self::TYPE_JPEG, float $quality = 1.0)
    {
        ob_start();
        $this->output(NULL, $type, $quality);
        return ob_get_clean();
    }

    /**
     * Output the image
     * @param string|NULL $path path to where save the image, if none given, then image will be displayed
     * @param string $type image type
     * @param float $quality image quality in 0-1 range
     */
    public function output(string $path = NULL, $type = self::TYPE_JPEG, float $quality = 1.0)
    {
        if ($this->saveWithAlpha)
            imagealphablending($this->handle, false);

        switch($type) {
            case self::TYPE_JPEG:
            case self::TYPE_JPG:
                imagejpeg($this->handle, $path, $quality * 100.0);
                break;
            case self::TYPE_PNG:
                imagepng($this->handle, $path, $quality * 9.0);
                break;
        }

        imagealphablending($this->handle, true);
    }
}