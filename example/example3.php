<?php

include('../vendor/autoload.php');

$img = \RWypior\Objgd\Image::createEmpty(new \RWypior\Objgd\Unit\Coord(500, 500));
$img->fill(\RWypior\Objgd\Unit\Color::fromName('transparent'));
$img->enableAlpha();

$square = new \RWypior\Objgd\Drawable\Rectangle(new \RWypior\Objgd\Unit\Coord('0', '0'), new \RWypior\Objgd\Unit\Coord('50%', '100%'));
$square->setFillColor(\RWypior\Objgd\Unit\Color::fromName('white'));
$square->setThickness(3);

$font = new \RWypior\Objgd\Font('fonts/Roboto-Regular.ttf', 'fonts/Roboto-Bold.ttf', 'fonts/Roboto-Italic.ttf');

$text = new \RWypior\Objgd\Drawable\Text();
$text->setFont($font);
$text->setSize(30);
$text->setText("Alpha image example");
$text->setAlign(\RWypior\Objgd\Unit\Align::center());
$text->setCoord(new \RWypior\Objgd\Unit\Coord('50%', 50));
$text->setColor(\RWypior\Objgd\Unit\Color::fromName('red'));

$img->drawElement($square)
    ->drawElement($text);

header('Content-Type: image/png');
$img->output(NULL,\RWypior\Objgd\Image::TYPE_PNG);