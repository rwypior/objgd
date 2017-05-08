<?php

namespace RWypior\Objgd;

class Font
{
    protected $regular;
    protected $bold;
    protected $italic;

    public function __construct(string $regular, string $bold = NULL, string $italic = NULL)
    {
        $this->regular = $regular;
        $this->bold = $bold ?? $regular;
        $this->italic = $italic ?? $regular;
    }

    public function variant(string $name)
    {
        switch($name)
        {
            case 'b':
            case 'bold':
                return $this->bold();
            case 'i':
            case 'italic':
                return $this->italic();
            case 'r':
            case 'regular':
            case '':
            default:
                return $this->regular();
        }
    }

    public function regular()
    {
        return $this->regular;
    }

    public function bold()
    {
        return $this->bold;
    }

    public function italic()
    {
        return $this->italic;
    }
}