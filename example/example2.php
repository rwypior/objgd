<?php

include('../vendor/autoload.php');

$img = \RWypior\Objgd\Image::createEmpty(new \RWypior\Objgd\Unit\Coord(500, 500));

$square = new \RWypior\Objgd\Drawable\Rectangle(new \RWypior\Objgd\Unit\Coord('70%', '55%'), new \RWypior\Objgd\Unit\Coord(50, 50));
$square->setFillColor(\RWypior\Objgd\Unit\Color::fromName('red'));
$square->setBorderColor(\RWypior\Objgd\Unit\Color::fromName('white'));
$square->setThickness(3);

$font = new \RWypior\Objgd\Font('fonts/Roboto-Regular.ttf', 'fonts/Roboto-Bold.ttf', 'fonts/Roboto-Italic.ttf');

$text = new \RWypior\Objgd\Drawable\Text();
$text->setFont($font);
$text->setSize(30);
$text->setText("Blurred image example");
$text->setAlign(\RWypior\Objgd\Unit\Align::center());
$text->setCoord(new \RWypior\Objgd\Unit\Coord('50%', 50));

$line = new \RWypior\Objgd\Drawable\Line(new \RWypior\Objgd\Unit\Coord(0, '50%'), new \RWypior\Objgd\Unit\Coord('100%', '50%'));

$circle = new \RWypior\Objgd\Drawable\Ellipse(new \RWypior\Objgd\Unit\Coord('70%', '75%'), new \RWypior\Objgd\Unit\Coord(50, 50));
$circle->setBorderColor(\RWypior\Objgd\Unit\Color::fromName('blue'));

$img->drawElement($square)
    ->drawElement($text)
    ->drawElement($circle)
    ->drawElement($line);

$gaussian = new \RWypior\Objgd\Effects\Gaussian(5);
$img->applyEffect($gaussian);

$text2 = new \RWypior\Objgd\Drawable\Text();
$text2->setFont($font);
$text2->setSize(30);
$text2->setText("Sharp image example");
$text2->setAlign(\RWypior\Objgd\Unit\Align::center());
$text2->setCoord(new \RWypior\Objgd\Unit\Coord('50%', 110));

$img->drawElement($text2);

header('Content-Type: image/jpeg');
$img->output();